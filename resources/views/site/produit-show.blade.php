<x-marketing-layout :title="'BioSachet Togo | '.$produit->nom">
    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="section-card">
                <p class="eyebrow">Fiche produit</p>
                <h1 class="mt-3 text-4xl font-bold text-stone-900">{{ $produit->nom }}</h1>
                <p class="mt-3 text-sm font-semibold uppercase tracking-[0.14em] text-stone-500">{{ $produit->usage_ideal }}</p>
                <p class="mt-5 text-base leading-8 text-stone-600">{{ $produit->description }}</p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($produit->badge_properties as $badge)
                        <span class="status-pill bg-stone-100 text-stone-700">{{ $badge }}</span>
                    @endforeach
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="metric-band">
                        <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Format</p>
                        <p class="mt-2 text-xl font-bold text-[var(--bio-green)]">{{ $produit->format }}</p>
                    </div>
                    <div class="metric-band">
                        <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Prix</p>
                        <p class="mt-2 text-xl font-bold text-[var(--bio-green)]">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="metric-band">
                        <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Sechage</p>
                        <p class="mt-2 text-xl font-bold text-[var(--bio-green)]">{{ $produit->sechage_label }}</p>
                    </div>
                </div>
            </div>

            <div class="panel-dark p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Commander</p>
                <h2 class="mt-3 text-3xl font-bold">Reference prete pour WhatsApp</h2>
                <p class="mt-4 text-white/75">Le message de commande pre-remplit le nom du produit et son usage ideal pour accelerer la prise de contact.</p>
                <a href="{{ $produit->whatsapp_order_url }}" target="_blank" rel="noopener" class="btn-primary mt-6 inline-flex bg-white text-[var(--bio-green)] hover:bg-stone-100">Commander sur WhatsApp</a>
                <a href="{{ route('site.panier') }}" class="btn-secondary mt-3 inline-flex border-white bg-white/10 text-white hover:bg-white hover:text-[var(--bio-green)]">Passer par le panier</a>
            </div>
        </div>
    </section>

    <section class="pb-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="section-card">
                <p class="eyebrow">Recette</p>
                <ul class="mt-5 space-y-3 text-sm leading-7 text-stone-700">
                    @foreach ($produit->recette ?? [] as $ingredient => $quantite)
                        <li class="rounded-[1.2rem] bg-stone-50 px-4 py-3">{{ $ingredient }}: {{ $quantite }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="section-card">
                <p class="eyebrow">Production</p>
                <h2 class="mt-3 text-2xl font-bold text-stone-900">Notes atelier</h2>
                <p class="mt-4 text-sm leading-8 text-stone-600">{{ $produit->notes_production }}</p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell">
            <div class="mb-8 flex items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Autres types</p>
                    <h2 class="mt-2 text-3xl font-bold text-stone-900">Les autres references officielles</h2>
                </div>
                <a href="{{ route('site.produits') }}" class="btn-secondary py-2">Retour au catalogue</a>
            </div>
            <div class="marketing-grid">
                @foreach ($relatedProduits as $relatedProduit)
                    <article class="card p-6">
                        <span class="rounded-full bg-[var(--bio-mist)] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--bio-green)]">{{ $relatedProduit->format }}</span>
                        <h3 class="mt-5 text-2xl font-bold text-stone-900">{{ $relatedProduit->nom }}</h3>
                        <p class="mt-3 text-sm leading-7 text-stone-600">{{ $relatedProduit->description }}</p>
                        <a href="{{ route('site.produits.show', $relatedProduit->slug) }}" class="btn-primary mt-6 inline-flex">Voir cette fiche</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-marketing-layout>
