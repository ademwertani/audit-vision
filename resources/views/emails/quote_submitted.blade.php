<h2>Nouvelle demande de devis</h2>
<p>
    <strong>Nom :</strong> {{ $quote->nom_beneficiaire ?? $quote->nom ?? '' }} {{ $quote->prenom_beneficiaire ?? '' }}<br>
    <strong>Email :</strong> {{ $quote->email ?? '-' }}<br>
    <strong>Téléphone :</strong> {{ $quote->telephone ?? '-' }}<br>
    <strong>Raison sociale :</strong> {{ $quote->raison_sociale ?? '-' }}<br>
    <strong>Adresse :</strong> {{ $quote->adresse ?? '-' }}<br>
    <strong>Secteur :</strong> {{ $quote->secteur ?? '-' }}<br>
</p>
<p>Le PDF récapitulatif est en pièce jointe.</p>
