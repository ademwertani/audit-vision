<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Demande de devis #{{ $quote->id }}</title>
  <style>
    /* ====== Styles simples, compatibles DomPDF ====== */
    @page { margin: 24px 28px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#222; }
    h1 { font-size: 20px; margin:0 0 10px; }
    h2 { font-size: 14px; margin:20px 0 8px; }
    h3 { font-size: 13px; margin:10px 0 6px; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    td, th { padding:6px 8px; border:1px solid #ddd; text-align:left; vertical-align:top; }
    th { background:#f7f7f7; }
    ul { margin: 6px 0 0 18px; }
    .muted{ color:#666; }
    .small{ font-size: 11px; }
  </style>
</head>
<body>
@php
  // --- Valeurs sûres
  $nom      = trim($quote->nom_beneficiaire ?? $quote->nom ?? '') ?: '-';
  $prenom   = trim($quote->prenom_beneficiaire ?? '') ?: '-';
  $email    = trim($quote->email ?? '') ?: '-';
  $tel      = trim($quote->telephone ?? '') ?: '-';
  $rs       = trim($quote->raison_sociale ?? '') ?: '-';
  $adresse  = trim($quote->adresse ?? '') ?: '-';
  $secteur  = trim($quote->secteur ?? '') ?: '-';

  // --- SIRET : 14 chiffres, formaté 3-3-3-5 (ex: 732 829 320 00074)
  $siretDigits = preg_replace('/\D/', '', (string)($quote->siret ?? ''));
  if (preg_match('/^(\d{3})(\d{3})(\d{3})(\d{5})$/', $siretDigits, $m)) {
      $siretFmt = "{$m[1]} {$m[2]} {$m[3]} {$m[4]}";
  } else {
      $siretFmt = $siretDigits !== '' ? $siretDigits : '-';
  }

  // --- Collections issues du contrôleur
  $ops = [];
  if (!empty($operations) && is_array($operations)) {
      $ops = array_values(array_unique(array_map('strval', $operations)));
  }

  $qs  = [];
  if (!empty($questions) && is_array($questions)) {
      $qs = $questions;
  }

  // --- Libellés propres
  $opLabels = [
    'deshumidificateur' => 'Déshumidificateur',
    'destratificateur'  => 'Destratificateur',
    'variateur'         => 'Variateur',
  ];

  $questionLabels = [
    // destratificateur
    'hauteur_ge_5'   => 'Hauteur sous plafond ≥ 5 m',
    'zone_stockage'  => 'Zone de stockage',
    // deshumidificateur
    'secteur_marche' => 'Secteur agriculture maraîchère',
    'surface_ge_200' => 'Surface de serre ≥ 200 m²',
    // variateur
    'type_froid'     => "Type d’installation (groupe froid)",
    'chambre_ge_10'  => 'Puissance nominale chambre froide ≥ 10 kW',
    'clim_ge_880'    => 'Puissance nominale climatisation de confort ≥ 80 kW',
  ];

  $labelize = function ($key) use ($questionLabels) {
      return $questionLabels[$key] ?? ucwords(str_replace('_', ' ', (string)$key));
  };

  $valToString = function ($v) {
      if (is_array($v)) {
          return implode(', ', array_map(function($x){
              return is_scalar($x) ? (string)$x : json_encode($x, JSON_UNESCAPED_UNICODE);
          }, $v));
      }
      return (string)$v;
  };
@endphp

<h1>Demande de devis #{{ $quote->id }}</h1>

<table>
  <tr><th>Nom bénéficiaire</th><td>{{ e($nom) }}</td></tr>
  <tr><th>Prénom bénéficiaire</th><td>{{ e($prenom) }}</td></tr>
  <tr><th>Email</th><td>{{ e($email) }}</td></tr>
  <tr><th>Téléphone</th><td>{{ e($tel) }}</td></tr>
  <tr><th>Raison sociale</th><td>{{ e($rs) }}</td></tr>
  <tr><th>SIRET</th><td>{{ e($siretFmt) }}</td></tr>
  <tr><th>Adresse</th><td>{{ e($adresse) }}</td></tr>
  <tr><th>Secteur</th><td>{{ e(ucfirst($secteur)) }}</td></tr>
</table>

@if(!empty($ops))
  <h2>Opérations sélectionnées</h2>
  <ul>
    @foreach($ops as $op)
      <li>{{ e($opLabels[$op] ?? ucfirst($op)) }}</li>
    @endforeach
  </ul>
@endif

@if(!empty($qs))
  <h2>Réponses aux questionnaires</h2>
  @foreach($qs as $op => $answers)
    @php $opTitle = $opLabels[$op] ?? ucfirst($op); @endphp
    <h3 style="margin: 8px 0 4px;">{{ e($opTitle) }}</h3>
    <table>
      @foreach((array)$answers as $k => $v)
        <tr>
          <th>{{ e($labelize($k)) }}</th>
          <td>{{ e($valToString($v)) }}</td>
        </tr>
      @endforeach
    </table>
  @endforeach
@endif

<p class="muted small">Généré le {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
