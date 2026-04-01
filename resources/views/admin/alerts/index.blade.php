<x-admin-layout title="Alertes" heading="Alertes">
    <div class="mb-6 grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <div class="panel-dark p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Centre d’attention</p>
            <h2 class="mt-2 text-2xl font-bold">Les alertes concentrent les risques immediats: stock, retards, impayes et matiere premiere.</h2>
        </div>
        <div class="section-card">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Resume</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <div class="metric-band p-4">
                    <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Stocks faibles</p>
                    <p class="mt-2 text-2xl font-bold text-red-600">{{ count($alerts['low_stock_products']) }}</p>
                </div>
                <div class="metric-band p-4">
                    <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Retards</p>
                    <p class="mt-2 text-2xl font-bold text-amber-600">{{ count($alerts['overdue_orders']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Stocks faibles</h2>
            <div class="mt-5 space-y-4">
                @forelse ($alerts['low_stock_products'] as $produit)
                    <div class="flex items-center justify-between rounded-[1.6rem] bg-red-50 px-4 py-4">
                        <div>
                            <p class="font-semibold text-stone-900">{{ $produit->nom }}</p>
                            <p class="text-sm text-stone-500">{{ $produit->format }}</p>
                        </div>
                        <span class="text-sm font-semibold text-red-600">{{ $produit->stock_disponible }} restants</span>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucun stock critique.</p>
                @endforelse
            </div>
        </div>

        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Commandes en retard</h2>
            <div class="mt-5 space-y-4">
                @forelse ($alerts['overdue_orders'] as $commande)
                    <div class="flex items-center justify-between rounded-[1.6rem] bg-amber-50 px-4 py-4">
                        <div>
                            <p class="font-semibold text-stone-900">{{ $commande->reference }}</p>
                            <p class="text-sm text-stone-500">{{ $commande->client->nom }} · {{ optional($commande->date_livraison)->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('admin.commandes.show', $commande) }}" class="text-sm font-semibold text-amber-700">Voir</a>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucune commande en retard.</p>
                @endforelse
            </div>
        </div>

        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Commandes impayees agees</h2>
            <div class="mt-5 space-y-4">
                @forelse ($alerts['unpaid_orders'] as $commande)
                    <div class="flex items-center justify-between rounded-[1.6rem] bg-stone-50 px-4 py-4">
                        <div>
                            <p class="font-semibold text-stone-900">{{ $commande->reference }}</p>
                            <p class="text-sm text-stone-500">{{ $commande->client->nom }} · {{ $commande->paiement_label }}</p>
                        </div>
                        <span class="text-sm font-semibold text-stone-700">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucune commande impayee agee.</p>
                @endforelse
            </div>
        </div>

        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Alerte manioc</h2>
            <div class="mt-5 rounded-[1.6rem] {{ $alerts['cassava_alert'] ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }} px-5 py-5">
                @if ($alerts['cassava_alert'])
                    <p class="font-semibold">Le stock de manioc est passe sous le seuil d’alerte.</p>
                    <p class="mt-2 text-sm">Il faut anticiper un nouvel achat de matiere premiere.</p>
                @else
                    <p class="font-semibold">Le stock de manioc est actuellement sous controle.</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
