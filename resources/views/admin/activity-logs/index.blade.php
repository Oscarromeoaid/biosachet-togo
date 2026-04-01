<x-admin-layout title="Journal d'activite" heading="Journal d'activite">
    <div class="mb-6">
        <form method="GET" class="flex flex-col gap-4 rounded-3xl bg-white p-5 shadow-sm md:flex-row md:items-end">
            <div class="md:w-72">
                <label class="label" for="section">Section</label>
                <select id="section" name="section" class="input">
                    <option value="">Toutes</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section }}" @selected(request('section') === $section)>{{ ucfirst($section) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Filtrer</button>
                <a href="{{ route('admin.activites.index') }}" class="btn-secondary">Reinitialiser</a>
            </div>
        </form>
    </div>

    <div class="card overflow-hidden">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Date</th>
                    <th class="px-6 py-4 text-left font-semibold">Utilisateur</th>
                    <th class="px-6 py-4 text-left font-semibold">Section</th>
                    <th class="px-6 py-4 text-left font-semibold">Action</th>
                    <th class="px-6 py-4 text-left font-semibold">Description</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 bg-white">
                @foreach ($logs as $log)
                    <tr>
                        <td class="px-6 py-4">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">{{ $log->user?->name ?: 'systeme' }}</td>
                        <td class="px-6 py-4">{{ ucfirst($log->section) }}</td>
                        <td class="px-6 py-4">{{ ucfirst($log->action) }}</td>
                        <td class="px-6 py-4">{{ $log->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $logs->links() }}</div>
</x-admin-layout>
