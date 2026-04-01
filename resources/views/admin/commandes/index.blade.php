<x-admin-layout title="Commandes" heading="Commandes">
    <div class="mb-6 grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <div class="panel-dark p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Pilotage commercial</p>
            <h2 class="mt-2 text-2xl font-bold">Filtrer rapidement les commandes et garder les actions utiles a portee.</h2>
            <div class="mt-5 flex flex-wrap gap-2">
                <span class="kpi-chip border-white/10 bg-white/10 text-white/80">{{ $commandes->total() }} commandes</span>
                <span class="kpi-chip border-white/10 bg-white/10 text-white/80">{{ count($statuts) }} statuts</span>
                <span class="kpi-chip border-white/10 bg-white/10 text-white/80">{{ $clients->count() }} clients filtres</span>
            </div>
        </div>

        <form method="GET" class="section-card grid gap-4 md:grid-cols-3">
            <div>
                <label class="label" for="statut">Statut</label>
                <select id="statut" name="statut" class="input">
                    <option value="">Tous</option>
                    @foreach ($statuts as $statut)
                        <option value="{{ $statut }}" @selected(request('statut') === $statut)>{{ ucfirst(str_replace('_', ' ', $statut)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="client_id">Client</label>
                <select id="client_id" name="client_id" class="input">
                    <option value="">Tous</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected((string) request('client_id') === (string) $client->id)>{{ $client->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="date">Date</label>
                <input id="date" type="date" name="date" value="{{ request('date') }}" class="input">
            </div>
            <div class="md:col-span-3 flex flex-wrap justify-end gap-3">
                <a href="{{ route('admin.commandes.index') }}" class="btn-secondary py-2">Reinitialiser</a>
                <button type="submit" class="btn-primary">Filtrer</button>
            </div>
        </form>
    </div>

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Liste</p>
            <h2 class="mt-2 text-2xl font-bold text-stone-900">Toutes les commandes</h2>
        </div>
        @if (auth()->user()->hasAnyAdminRole([\App\Models\User::ADMIN_ROLE_SUPER_ADMIN, \App\Models\User::ADMIN_ROLE_OPERATIONS]))
            <a href="{{ route('admin.commandes.create') }}" class="btn-primary">Nouvelle commande</a>
        @endif
    </div>

    <div class="table-shell">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50/80">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Commande</th>
                        <th class="px-6 py-4 text-left font-semibold">Client</th>
                        <th class="px-6 py-4 text-left font-semibold">Statut</th>
                        <th class="px-6 py-4 text-left font-semibold">Paiement</th>
                        <th class="px-6 py-4 text-left font-semibold">Total</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white/70">
                    @foreach ($commandes as $commande)
                        <tr class="transition hover:bg-[var(--bio-mist)]/50">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-stone-900">{{ $commande->reference }}</p>
                                <p class="text-stone-500">{{ $commande->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-semibold text-stone-800">{{ $commande->client->nom }}</p>
                                <p class="text-stone-500">{{ $commande->client->ville }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="status-pill bg-[var(--bio-mist)] text-[var(--bio-green)]">{{ $commande->statut_label }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="status-pill {{ $commande->paiement === 'paye' ? 'bg-emerald-50 text-emerald-700' : ($commande->paiement === 'partiel' ? 'bg-amber-50 text-amber-700' : 'bg-stone-100 text-stone-700') }}">{{ $commande->paiement_label }}</span>
                            </td>
                            <td class="px-6 py-5 font-semibold text-stone-900">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.commandes.show', $commande) }}" class="text-[var(--bio-green)]">Voir</a>
                                    @if (auth()->user()->hasAnyAdminRole([\App\Models\User::ADMIN_ROLE_SUPER_ADMIN, \App\Models\User::ADMIN_ROLE_OPERATIONS]))
                                        <a href="{{ route('admin.commandes.edit', $commande) }}" class="text-[var(--bio-green)]">Modifier</a>
                                        <form method="POST" action="{{ route('admin.commandes.destroy', $commande) }}" onsubmit="return confirm('Supprimer cette commande ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Supprimer</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $commandes->links() }}</div>
</x-admin-layout>
