<table>
    <tr><td colspan="6"><strong>Rapport d'impact environnemental</strong></td></tr>
    <tr><td>Plastique evite</td><td>{{ $impact['plastic_avoided_kg'] }}</td><td>Clients servis</td><td>{{ $impact['clients_served'] }}</td><td>Ecoles partenaires</td><td>{{ $impact['partner_schools'] }}</td></tr>
    <tr><td colspan="6"></td></tr>
    <tr><th>Date</th><th>Manioc</th><th>Petit</th><th>Moyen</th><th>Grand</th><th>Film (m2)</th></tr>
    @foreach ($productions as $production)
        <tr>
            <td>{{ $production->date->format('Y-m-d') }}</td>
            <td>{{ $production->kg_manioc_utilise }}</td>
            <td>{{ $production->sachets_petit_transparent }}</td>
            <td>{{ $production->sachets_moyen_souple }}</td>
            <td>{{ $production->sachets_grand_solide }}</td>
            <td>{{ $production->film_biodegradable_m2 }}</td>
        </tr>
    @endforeach
</table>
