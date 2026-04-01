<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #173618; font-size: 12px; }
        h1, h2, h3 { margin: 0 0 10px; }
        .hero { margin-bottom: 18px; }
        .grid { width: 100%; }
        .card { border: 1px solid #d6dccd; border-radius: 12px; padding: 14px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th, td { border: 1px solid #dfe4d7; padding: 8px; text-align: left; }
        .right { text-align: right; }
        .muted { color: #5b6e5b; }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Devis BioSachet Togo</h1>
        <p class="muted">{{ config('biosachet.adresse') }} · {{ config('biosachet.telephone') }} · {{ config('biosachet.email') }}</p>
    </div>

    <div class="card">
        <h2>Commande {{ $commande->reference }}</h2>
        <p><strong>Client:</strong> {{ $commande->client->nom }}</p>
        <p><strong>Telephone:</strong> {{ $commande->client->telephone }}</p>
        <p><strong>Ville:</strong> {{ $commande->client->ville }}</p>
        <p><strong>Mode de paiement prevu:</strong> {{ $commande->methode_paiement_label }}</p>
        <p><strong>Livraison souhaitee:</strong> {{ optional($commande->date_livraison)->format('d/m/Y') ?: 'A confirmer' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Format</th>
                <th>Quantite</th>
                <th>Prix unitaire</th>
                <th>Total ligne</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($commande->produits as $produit)
                <tr>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->format }}</td>
                    <td>{{ $produit->pivot->quantite }}</td>
                    <td>{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card right" style="margin-top: 16px;">
        <h3>Total devis</h3>
        <p style="font-size: 22px; font-weight: bold;">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
    </div>

    <div class="card">
        <p><strong>Statut actuel:</strong> {{ $commande->statut_label }}</p>
        <p><strong>Reference de suivi:</strong> {{ $commande->reference }}</p>
        <p class="muted">Ce document peut servir de base de confirmation avant traitement final par l'equipe BioSachet Togo.</p>
    </div>
</body>
</html>
