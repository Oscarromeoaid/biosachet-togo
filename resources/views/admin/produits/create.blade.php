<x-admin-layout title="Nouveau produit" heading="Nouveau produit">
    <form method="POST" action="{{ route('admin.produits.store') }}" class="card p-6 space-y-6">
        @csrf
        @include('admin.produits._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</x-admin-layout>
