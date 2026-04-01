<table>
    <tr><td colspan="7"><strong>Rapport production par type</strong></td></tr>
    <tr><td>Total manioc</td><td>{{ $totals['kg_manioc_utilise'] }}</td><td>Petit</td><td>{{ $totals['sachets_petit_transparent'] }}</td><td>Moyen</td><td>{{ $totals['sachets_moyen_souple'] }}</td><td></td></tr>
    <tr><td>Grand</td><td>{{ $totals['sachets_grand_solide'] }}</td><td>Film (m2)</td><td>{{ $totals['film_biodegradable_m2'] }}</td><td colspan="3"></td></tr>
    <tr><td colspan="7"></td></tr>
    <tr>
        <th>Date</th>
        <th>Manioc (kg)</th>
        <th>Petit transparent</th>
        <th>Moyen souple</th>
        <th>Grand solide</th>
        <th>Film biodegradable (m2)</th>
        <th>Notes</th>
    </tr>
    @foreach ($productions as $production)
        <tr>
            <td>{{ $production->date->format('Y-m-d') }}</td>
            <td>{{ $production->kg_manioc_utilise }}</td>
            <td>{{ $production->sachets_petit_transparent }}</td>
            <td>{{ $production->sachets_moyen_souple }}</td>
            <td>{{ $production->sachets_grand_solide }}</td>
            <td>{{ $production->film_biodegradable_m2 }}</td>
            <td>{{ $production->notes }}</td>
        </tr>
    @endforeach
</table>
