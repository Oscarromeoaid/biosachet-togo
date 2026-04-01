<x-admin-layout title="Dashboard BioSachet" heading="Dashboard">
    <livewire:dashboard-stats />

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="section-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Flux commercial</p>
                    <h2 class="mt-2 text-2xl font-bold text-stone-900">Dernieres commandes</h2>
                </div>
                <a href="{{ route('admin.commandes.index') }}" class="btn-secondary py-2">Voir tout</a>
            </div>
            <div class="mt-5 space-y-4">
                @foreach ($recentCommandes as $commande)
                    <div class="flex flex-col gap-3 rounded-[1.6rem] border border-white/70 bg-white/80 px-5 py-4 shadow-sm shadow-stone-200/50 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-stone-900">{{ $commande->reference }} · {{ $commande->client->nom }}</p>
                            <p class="text-sm text-stone-500">{{ $commande->created_at->format('d/m/Y') }} · {{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <span class="status-pill bg-[var(--bio-mist)] text-[var(--bio-green)]">{{ $commande->statut_label }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel-dark p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Lecture rapide</p>
            <h2 class="mt-2 text-2xl font-bold">Produits a surveiller</h2>
            <div class="mt-5 space-y-4">
                @forelse ($lowStockProduits as $produit)
                    <div class="glass-panel p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold">{{ $produit->nom }}</p>
                                <p class="text-sm text-white/65">{{ $produit->format }}</p>
                            </div>
                            <span class="rounded-full bg-red-500/20 px-3 py-1 text-xs font-semibold text-red-100">{{ $produit->stock_disponible }} restants</span>
                        </div>
                    </div>
                @empty
                    <div class="glass-panel p-4">
                        <p class="text-sm text-white/75">Aucun produit en zone critique pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-3">
        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Top produits du mois</h2>
            <div class="mt-5 space-y-4">
                @forelse ($insights['top_products'] as $produit)
                    <div class="rounded-[1.6rem] border border-white/70 bg-white/80 px-4 py-4 shadow-sm shadow-stone-200/40">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-stone-900">{{ $produit->nom }}</p>
                                <p class="text-sm text-stone-500">{{ $produit->format }}</p>
                            </div>
                            <span class="kpi-chip">{{ (int) $produit->quantite_totale }} unites</span>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-stone-700">{{ number_format($produit->chiffre_affaires, 0, ',', ' ') }} FCFA</p>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Pas encore assez de ventes sur la periode.</p>
                @endforelse
            </div>
        </div>

        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Meilleurs clients du mois</h2>
            <div class="mt-5 space-y-4">
                @forelse ($insights['top_clients'] as $client)
                    <div class="rounded-[1.6rem] border border-white/70 bg-white/80 px-4 py-4 shadow-sm shadow-stone-200/40">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-stone-900">{{ $client->nom }}</p>
                                <p class="text-sm text-stone-500">{{ ucfirst($client->type) }} · {{ (int) $client->commandes_count }} commande(s)</p>
                            </div>
                            <span class="text-sm font-semibold text-[var(--bio-green)]">{{ number_format($client->revenu_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucun client notable sur la periode.</p>
                @endforelse
            </div>
        </div>

        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Modes de paiement</h2>
            <div class="mt-5 space-y-4">
                @php($maxPayment = collect($insights['payment_breakdown'])->max('total_ca') ?: 1)
                @forelse ($insights['payment_breakdown'] as $payment)
                    <div class="rounded-[1.6rem] border border-white/70 bg-white/80 px-4 py-4 shadow-sm shadow-stone-200/40">
                        <div class="flex items-center justify-between gap-4">
                            <p class="font-semibold text-stone-900">{{ $payment['label'] }}</p>
                            <p class="text-sm text-stone-500">{{ $payment['total_commandes'] }} commande(s)</p>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-stone-100">
                            <div class="h-2 rounded-full bg-[linear-gradient(90deg,#7ba05b_0%,#2c5f2d_100%)]" style="width: {{ max(8, ($payment['total_ca'] / $maxPayment) * 100) }}%"></div>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-stone-700">{{ number_format($payment['total_ca'], 0, ',', ' ') }} FCFA</p>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucune commande a analyser sur la periode.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1fr_1fr]">
        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Retards de livraison</h2>
            <div class="mt-5 space-y-4">
                @forelse ($insights['late_deliveries'] as $commande)
                    <div class="flex items-center justify-between rounded-[1.6rem] bg-amber-50 px-4 py-4">
                        <div>
                            <p class="font-semibold text-stone-900">{{ $commande->reference }} · {{ $commande->client->nom }}</p>
                            <p class="text-sm text-stone-600">Livraison prevue le {{ optional($commande->date_livraison)->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('admin.commandes.show', $commande) }}" class="text-sm font-semibold text-amber-700">Voir</a>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucun retard de livraison detecte.</p>
                @endforelse
            </div>
        </div>

        <div class="section-card">
            <h2 class="text-xl font-bold text-stone-900">Pression sur le stock</h2>
            <div class="mt-5 space-y-4">
                @forelse ($insights['stock_pressure'] as $item)
                    <div class="rounded-[1.6rem] border border-white/70 bg-white/80 px-4 py-4 shadow-sm shadow-stone-200/40">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-stone-900">{{ $item['nom'] }}</p>
                                <p class="text-sm text-stone-500">{{ $item['format'] }}</p>
                            </div>
                            <span class="status-pill {{ $item['disponible_commande'] < 50 ? 'bg-red-50 text-red-600' : 'bg-[var(--bio-mist)] text-[var(--bio-green)]' }}">
                                {{ $item['disponible_commande'] }} dispo commande
                            </span>
                        </div>
                        <div class="mt-3 flex gap-6 text-sm text-stone-600">
                            <p>Stock physique: {{ $item['stock_disponible'] }}</p>
                            <p>Reserve: {{ $item['reserve'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Pas de tension particuliere sur les references suivies.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 section-card">
        <h2 class="text-xl font-bold text-stone-900">Derniers mouvements de stock</h2>
        <div class="mt-5 space-y-4">
            @forelse ($insights['recent_stock_movements'] as $movement)
                <div class="flex flex-col gap-3 rounded-[1.6rem] border border-white/70 bg-white/80 px-4 py-4 shadow-sm shadow-stone-200/40 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="font-semibold text-stone-900">{{ $movement->produit->nom }}</p>
                        <p class="text-sm text-stone-500">{{ $movement->type }} · {{ $movement->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex flex-wrap gap-4 text-sm text-stone-600">
                        <p>Qte: {{ $movement->quantite }}</p>
                        <p>Avant: {{ $movement->stock_avant }}</p>
                        <p>Apres: {{ $movement->stock_apres }}</p>
                        <p>{{ $movement->commande?->reference }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-stone-500">Aucun mouvement de stock journalise pour le moment.</p>
            @endforelse
        </div>
    </div>
</x-admin-layout>
