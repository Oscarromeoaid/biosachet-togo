<table>
    <tr><td colspan="4"><strong>Rapport financier</strong></td></tr>
    <tr><td>Revenus</td><td>{{ $financial['revenue'] }}</td><td>Couts</td><td>{{ $financial['costs'] }}</td></tr>
    <tr><td>Profit net</td><td>{{ $financial['net_profit'] }}</td><td>Matieres</td><td>{{ $financial['raw_material_costs'] }}</td></tr>
    <tr><td colspan="4"></td></tr>
    <tr><th>#</th><th>Client</th><th>Total</th><th>Statut</th></tr>
    @foreach ($commandes as $commande)
        <tr>
            <td>{{ $commande->id }}</td>
            <td>{{ $commande->client->nom }}</td>
            <td>{{ $commande->total }}</td>
            <td>{{ $commande->statut }}</td>
        </tr>
    @endforeach
</table>
