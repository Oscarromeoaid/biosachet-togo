<x-marketing-layout title="BioSachet Togo | Produits">
    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="section-card">
                <p class="eyebrow">Catalogue produit</p>
                <h1 class="mt-3 text-4xl font-bold text-stone-900">4 types exacts pour les usages les plus courants</h1>
                <p class="mt-4 max-w-3xl text-lg leading-8 text-stone-600">Le catalogue est volontairement court: un petit sachet transparent, un sachet moyen souple, un grand sachet solide et un film biodegradable. Chaque produit suit sa propre recette, son propre temps de sechage et son propre usage ideal.</p>
            </div>
            <div class="panel-dark p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Lecture rapide</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/55">Produits</p>
                        <p class="mt-2 text-2xl font-bold">{{ $produits->count() }}</p>
                    </div>
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/55">Prix</p>
                        <p class="mt-2 text-2xl font-bold">20 a 50 FCFA</p>
                    </div>
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/55">Commande</p>
                        <p class="mt-2 text-2xl font-bold">WhatsApp direct</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-16">
        <div class="container-shell">
            <div class="marketing-grid">
                @foreach ($produits as $produit)
                    <article class="card overflow-hidden p-7">
                        <div class="flex items-center justify-between gap-4">
                            <span class="rounded-full bg-[var(--bio-mist)] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--bio-green)]">{{ $produit->format }}</span>
                            <span class="kpi-chip">{{ $produit->sechage_label }}</span>
                        </div>

                        <h2 class="mt-5 text-2xl font-bold text-stone-900">{{ $produit->nom }}</h2>
                        <p class="mt-2 text-sm font-semibold uppercase tracking-[0.12em] text-stone-500">{{ $produit->usage_ideal }}</p>
                        <p class="mt-4 text-sm leading-7 text-stone-600">{{ $produit->description }}</p>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($produit->badge_properties as $propriete)
                                <span class="status-pill bg-stone-100 text-stone-700">{{ $propriete }}</span>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-end justify-between">
                            <div>
                                <p class="text-sm text-stone-500">Prix unitaire</p>
                                <p class="text-3xl font-bold text-[var(--bio-green)]">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-stone-500">Sechage</p>
                                <p class="text-lg font-bold text-stone-900">{{ $produit->sechage_label }}</p>
                            </div>
                        </div>

                        <div class="mt-6 rounded-[1.6rem] bg-stone-50 px-4 py-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Recette</p>
                            <ul class="mt-3 space-y-2 text-sm text-stone-600">
                                @foreach ($produit->recette ?? [] as $ingredient => $quantite)
                                    <li>{{ $ingredient }}: {{ $quantite }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            <a href="{{ route('site.produits.show', $produit->slug) }}" class="btn-secondary w-full text-center">Voir la fiche</a>
                            <a href="{{ $produit->whatsapp_order_url }}" target="_blank" rel="noopener" class="btn-primary w-full text-center">Commander</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-4">
            @foreach ($useCases as $useCase)
                <article class="section-card">
                    <p class="eyebrow">Usage</p>
                    <h2 class="mt-3 text-2xl font-bold text-stone-900">{{ $useCase['titre'] }}</h2>
                    <p class="mt-4 text-sm leading-7 text-stone-600">{{ $useCase['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
</x-marketing-layout>
