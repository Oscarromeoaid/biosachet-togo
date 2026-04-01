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
    <h1>Rapport d'impact environnemental</h1>
    <div class="card">Plastique evite: {{ number_format($impact['plastic_avoided_kg'], 2, ',', ' ') }} kg</div>
    <div class="card">Clients servis: {{ $impact['clients_served'] }}</div>
    <div class="card">Ecoles partenaires: {{ $impact['partner_schools'] }}</div>

    <h2>Productions recentes</h2>
    <table>
        <thead>
            <tr><th>Date</th><th>Manioc</th><th>Petit</th><th>Moyen</th><th>Grand</th><th>Film (m2)</th></tr>
        </thead>
        <tbody>
            @foreach ($productions as $production)
                <tr>
                    <td>{{ $production->date->format('d/m/Y') }}</td>
                    <td>{{ number_format($production->kg_manioc_utilise, 2, ',', ' ') }} kg</td>
                    <td>{{ number_format($production->sachets_petit_transparent, 0, ',', ' ') }}</td>
                    <td>{{ number_format($production->sachets_moyen_souple, 0, ',', ' ') }}</td>
                    <td>{{ number_format($production->sachets_grand_solide, 0, ',', ' ') }}</td>
                    <td>{{ number_format($production->film_biodegradable_m2, 2, ',', ' ') }} m2</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
