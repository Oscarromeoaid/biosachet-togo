<x-admin-layout title="Productions" heading="Productions journalieres">
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-stone-500">Suivi quotidien des volumes produits par type et du manioc utilise.</p>
        <a href="{{ route('admin.productions.create') }}" class="btn-primary">Nouvelle production</a>
    </div>

    <div class="table-shell">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Date</th>
                        <th class="px-6 py-4 text-left font-semibold">Manioc</th>
                        <th class="px-6 py-4 text-left font-semibold">Petit</th>
                        <th class="px-6 py-4 text-left font-semibold">Moyen</th>
                        <th class="px-6 py-4 text-left font-semibold">Grand</th>
                        <th class="px-6 py-4 text-left font-semibold">Film</th>
                        <th class="px-6 py-4 text-left font-semibold">Plastique evite</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @foreach ($productions as $production)
                        <tr>
                            <td class="px-6 py-4">{{ $production->date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">{{ number_format($production->kg_manioc_utilise, 2, ',', ' ') }} kg</td>
                            <td class="px-6 py-4">{{ number_format($production->sachets_petit_transparent, 0, ',', ' ') }}</td>
                            <td class="px-6 py-4">{{ number_format($production->sachets_moyen_souple, 0, ',', ' ') }}</td>
                            <td class="px-6 py-4">{{ number_format($production->sachets_grand_solide, 0, ',', ' ') }}</td>
                            <td class="px-6 py-4">{{ number_format($production->film_biodegradable_m2, 2, ',', ' ') }} m2</td>
                            <td class="px-6 py-4">{{ number_format($production->plastique_evite_kg, 2, ',', ' ') }} kg</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.productions.edit', $production) }}" class="text-[var(--bio-green)]">Modifier</a>
                                    <form method="POST" action="{{ route('admin.productions.destroy', $production) }}" onsubmit="return confirm('Supprimer cette production ?');">
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
    </div>
    <div class="mt-6">{{ $productions->links() }}</div>
</x-admin-layout>
