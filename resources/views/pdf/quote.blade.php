<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Demande de devis #{{ $quote->id }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#222; }
    h1 { font-size: 20px; margin:0 0 10px; }
    h2 { font-size: 14px; margin:20px 0 8px; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    td, th { padding:6px 8px; border:1px solid #ddd; text-align:left; vertical-align:top; }
    .muted{ color:#666; }
  </style>
</head>
<body>
  <h1>Demande de devis #{{ $quote->id }}</h1>
  <table>
    <tr><th>Nom bénéficiaire</th><td>{{ $quote->nom_beneficiaire ?? $quote->nom ?? '-' }}</td></tr>
    <tr><th>Prénom bénéficiaire</th><td>{{ $quote->prenom_beneficiaire ?? '-' }}</td></tr>
    <tr><th>Email</th><td>{{ $quote->email ?? '-' }}</td></tr>
    <tr><th>Téléphone</th><td>{{ $quote->telephone ?? '-' }}</td></tr>
    <tr><th>Raison sociale</th><td>{{ $quote->raison_sociale ?? '-' }}</td></tr>
    <tr><th>Adresse</th><td>{{ $quote->adresse ?? '-' }}</td></tr>
    <tr><th>Secteur</th><td>{{ $quote->secteur ?? '-' }}</td></tr>
  </table>

  @if(!empty($operations) && is_array($operations))
    <h2>Opérations sélectionnées</h2>
    <ul>
      @foreach($operations as $op)
        <li>{{ ucfirst($op) }}</li>
      @endforeach
    </ul>
  @endif

  @if(!empty($questions) && is_array($questions))
    <h2>Réponses aux questionnaires</h2>
    @foreach($questions as $op => $qs)
      <h3 style="margin: 8px 0 4px;">{{ ucfirst($op) }}</h3>
      <table>
        @foreach($qs as $k => $v)
          <tr>
            <th>{{ str_replace('_',' ', $k) }}</th>
            <td>{{ is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v }}</td>
          </tr>
        @endforeach
      </table>
    @endforeach
  @endif

  <p class="muted">Généré le {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
