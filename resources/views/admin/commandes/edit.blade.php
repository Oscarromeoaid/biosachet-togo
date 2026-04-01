<x-admin-layout title="Modifier commande" heading="Modifier commande">
    <livewire:order-form
        :commande="$commande"
        :clients="$clients"
        :produits="$produits"
        :action="route('admin.commandes.update', $commande)"
        http-method="PUT"
        :initial-lines="old('produits', [])"
        :initial-client-id="old('client_id') ? (int) old('client_id') : $commande->client_id"
        :initial-statut="old('statut', $commande->statut)"
        :initial-paiement="old('paiement', $commande->paiement)"
        :initial-methode-paiement="old('methode_paiement', $commande->methode_paiement)"
        :initial-date-livraison="old('date_livraison', optional($commande->date_livraison)->toDateString())"
    />
</x-admin-layout>
