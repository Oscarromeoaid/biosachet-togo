<x-admin-layout title="Clients" heading="Clients">
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-stone-500">Base clients des commerces, restaurants, ONG et grossistes.</p>
        <a href="{{ route('admin.clients.create') }}" class="btn-primary">Nouveau client</a>
    </div>

    <div class="card overflow-hidden">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Nom</th>
                    <th class="px-6 py-4 text-left font-semibold">Telephone</th>
                    <th class="px-6 py-4 text-left font-semibold">Type</th>
                    <th class="px-6 py-4 text-left font-semibold">Ville</th>
                    <th class="px-6 py-4 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 bg-white">
                @foreach ($clients as $client)
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-semibold">{{ $client->nom }}</p>
                            <p class="text-stone-500">{{ $client->email }}</p>
                        </td>
                        <td class="px-6 py-4">{{ $client->telephone }}</td>
                        <td class="px-6 py-4">{{ $client->type_label }}</td>
                        <td class="px-6 py-4">{{ $client->ville }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.clients.edit', $client) }}" class="text-[var(--bio-green)]">Modifier</a>
                                <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Supprimer ce client ?');">
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

    <div class="mt-6">{{ $clients->links() }}</div>
</x-admin-layout>
