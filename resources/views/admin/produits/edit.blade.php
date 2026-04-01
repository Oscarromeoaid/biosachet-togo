<x-admin-layout title="Modifier produit" heading="Modifier produit">
    <form method="POST" action="{{ route('admin.produits.update', $produit) }}" class="card p-6 space-y-6">
        @csrf
        @method('PUT')
        @if ($identityLocked ?? false)
            <div class="rounded-[1.5rem] border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-800">
                L identite de ce produit officiel est verrouillee. Vous pouvez encore ajuster le prix, le stock et les informations de production.
            </div>
        @endif
        @include('admin.produits._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Mettre a jour</button>
        </div>
    </form>
</x-admin-layout>
