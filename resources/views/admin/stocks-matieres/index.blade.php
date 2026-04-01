<x-admin-layout title="Stock matière" heading="Stock matière">
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-stone-500">Historique des achats de manioc et autres intrants.</p>
        <a href="{{ route('admin.stocks-matieres.create') }}" class="btn-primary">Nouvel achat</a>
    </div>

    <div class="card overflow-hidden">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Date</th>
                    <th class="px-6 py-4 text-left font-semibold">Quantite</th>
                    <th class="px-6 py-4 text-left font-semibold">Cout</th>
                    <th class="px-6 py-4 text-left font-semibold">Fournisseur</th>
                    <th class="px-6 py-4 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 bg-white">
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="px-6 py-4">{{ $stock->date_achat->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ number_format($stock->quantite_kg, 2, ',', ' ') }} kg</td>
                        <td class="px-6 py-4">{{ number_format($stock->cout_total, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4">{{ $stock->fournisseur }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.stocks-matieres.edit', $stock) }}" class="text-[var(--bio-green)]">Modifier</a>
                                <form method="POST" action="{{ route('admin.stocks-matieres.destroy', $stock) }}" onsubmit="return confirm('Supprimer cette entree ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $stocks->links() }}</div>
</x-admin-layout>
