<x-admin-layout title="Nouvelle commande" heading="Nouvelle commande">
    <livewire:order-form
        :commande="$commande"
        :clients="$clients"
        :produits="$produits"
        :action="route('admin.commandes.store')"
        http-method="POST"
        :initial-lines="old('produits', [])"
        :initial-client-id="old('client_id') ? (int) old('client_id') : null"
        :initial-statut="old('statut')"
        :initial-paiement="old('paiement')"
        :initial-methode-paiement="old('methode_paiement')"
        :initial-date-livraison="old('date_livraison')"
    />
</x-admin-layout>
