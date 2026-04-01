<x-admin-layout title="Produits" heading="Produits">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-stone-500">Catalogue interne des 4 references biodegradables et de leurs recettes.</p>
            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-stone-400">Catalogue verrouille a 4 types officiels.</p>
        </div>
        @if ($canCreateProduit)
            <a href="{{ route('admin.produits.create') }}" class="btn-primary">Nouveau produit</a>
        @endif
    </div>

    <div class="table-shell">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Nom</th>
                        <th class="px-6 py-4 text-left font-semibold">Format</th>
                        <th class="px-6 py-4 text-left font-semibold">Usage</th>
                        <th class="px-6 py-4 text-left font-semibold">Sechage</th>
                        <th class="px-6 py-4 text-left font-semibold">Prix</th>
                        <th class="px-6 py-4 text-left font-semibold">Stock</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @foreach ($produits as $produit)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-semibold">{{ $produit->nom }}</p>
                                <p class="text-stone-500">{{ $produit->proprietes_text }}</p>
                            </td>
                            <td class="px-6 py-4">{{ $produit->format }}</td>
                            <td class="px-6 py-4">{{ $produit->usage_ideal }}</td>
                            <td class="px-6 py-4">{{ $produit->sechage_label }}</td>
                            <td class="px-6 py-4">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="px-6 py-4">{{ $produit->stock_disponible }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.produits.edit', $produit) }}" class="text-[var(--bio-green)]">Modifier</a>
                                    <span class="text-stone-300">|</span>
                                    <span class="text-stone-400">Verrouille</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $produits->links() }}</div>
</x-admin-layout>
