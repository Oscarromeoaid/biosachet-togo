<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #173618; font-size: 12px; }
        h1, h2 { margin: 0 0 10px; }
        .card { border: 1px solid #d6dccd; border-radius: 12px; padding: 14px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th, td { border: 1px solid #dfe4d7; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Rapport financier</h1>
    <div class="card">Revenus: {{ number_format($financial['revenue'], 0, ',', ' ') }} FCFA</div>
    <div class="card">Couts: {{ number_format($financial['costs'], 0, ',', ' ') }} FCFA</div>
    <div class="card">Profit net: {{ number_format($financial['net_profit'], 0, ',', ' ') }} FCFA</div>

    <h2>Dernieres commandes</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Client</th><th>Total</th><th>Statut</th></tr>
        </thead>
        <tbody>
            @foreach ($commandes as $commande)
                <tr>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->client->nom }}</td>
                    <td>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $commande->statut_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Achats de matieres</h2>
    <table>
        <thead>
            <tr><th>Date</th><th>Fournisseur</th><th>Quantite</th><th>Cout</th></tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->date_achat->format('d/m/Y') }}</td>
                    <td>{{ $stock->fournisseur }}</td>
                    <td>{{ number_format($stock->quantite_kg, 2, ',', ' ') }} kg</td>
                    <td>{{ number_format($stock->cout_total, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
