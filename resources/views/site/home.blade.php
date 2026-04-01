<x-marketing-layout title="BioSachet Togo | Accueil">
    <section class="relative overflow-hidden bg-[linear-gradient(135deg,#102411_0%,#173618_32%,#2c5f2d_65%,#7ba05b_100%)] py-20 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_32%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.08),transparent_28%)]"></div>
        <div class="container-shell relative grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white/80 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    Sachets biodegradables au manioc
                </div>
                <h1 class="mt-6 max-w-4xl text-5xl font-bold leading-tight lg:text-6xl">{{ config('biosachet.tagline') }}</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-white/80">BioSachet Togo fabrique a Lome des sachets compostables issus de l’amidon de manioc pour les commerces, restaurants, ONG, pharmacies et grossistes. La promesse est simple: garder la praticite du sachet, sans continuer a charger les decharges locales.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('site.produits') }}" class="btn-primary bg-white text-[var(--bio-green)] hover:bg-stone-100">Voir les produits</a>
                    <a href="{{ route('site.panier') }}" class="btn-secondary border-white bg-white/10 text-white hover:bg-white hover:text-[var(--bio-green)]">Commander maintenant</a>
                </div>
                <div class="mt-10 grid max-w-3xl gap-4 sm:grid-cols-3">
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-white/60">Formats</p>
                        <p class="mt-2 text-2xl font-bold">500g, 1kg, 2kg</p>
                    </div>
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-white/60">Prix</p>
                        <p class="mt-2 text-2xl font-bold">20 a 50 FCFA</p>
                    </div>
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-white/60">Canal</p>
                        <p class="mt-2 text-2xl font-bold">WhatsApp direct</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="glass-panel p-6 sm:col-span-2">
                    <p class="text-xs uppercase tracking-[0.22em] text-white/55">Impact visible</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-4xl font-bold">{{ number_format($metrics['plastic_avoided_kg'], 2, ',', ' ') }}</p>
                            <p class="mt-2 text-sm text-white/70">kg de plastique evites depuis les productions enregistrees</p>
                        </div>
                        <div class="rounded-[1.6rem] border border-white/10 bg-white/10 p-4">
                            <p class="text-sm text-white/70">Capacite de lancement</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format(config('biosachet.launch_capacity_per_day'), 0, ',', ' ') }}</p>
                            <p class="text-sm text-white/60">sachets par jour</p>
                        </div>
                    </div>
                </div>
                <div class="glass-panel p-6">
                    <p class="text-sm text-white/70">Clients servis</p>
                    <p class="mt-3 text-4xl font-bold">{{ $metrics['clients_served'] }}</p>
                    <p class="mt-2 text-sm text-white/70">acteurs economiques accompagnes</p>
                </div>
                <div class="glass-panel p-6">
                    <p class="text-sm text-white/70">Ecoles partenaires</p>
                    <p class="mt-3 text-4xl font-bold">{{ $metrics['partner_schools'] }}</p>
                    <p class="mt-2 text-sm text-white/70">sensibilisation environnementale</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
            <div class="section-card">
                <p class="eyebrow">Positionnement</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-900">Une offre locale, concrete et vendable</h2>
                <p class="mt-4 text-base leading-8 text-stone-600">Le projet ne vend pas seulement un sachet “eco”. Il propose une alternative industrielle legere, adaptee au terrain, avec des formats lisibles, un prix accessible et une logistique simple pour les clients de Lome et au-dela.</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="metric-band">
                        <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Usage</p>
                        <p class="mt-2 text-2xl font-bold text-[var(--bio-green)]">Commerce de proximite</p>
                    </div>
                    <div class="metric-band">
                        <p class="text-xs uppercase tracking-[0.18em] text-stone-500">Developpement</p>
                        <p class="mt-2 text-2xl font-bold text-[var(--bio-green)]">Mini-factory an 2</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ($advantages as $advantage)
                    <div class="section-card">
                        <span class="kpi-chip">Atout</span>
                        <p class="mt-4 text-base leading-7 text-stone-700">{{ $advantage }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell">
            <div class="mb-8 flex items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Catalogue</p>
                    <h2 class="mt-2 text-3xl font-bold text-stone-900">Formats disponibles</h2>
                </div>
                <a href="{{ route('site.produits') }}" class="btn-secondary py-2">Tous les produits</a>
            </div>
            <div class="marketing-grid">
                @foreach ($produits as $produit)
                    <article class="card group overflow-hidden p-6 transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex items-start justify-between gap-4">
                            <div class="inline-flex rounded-full bg-[var(--bio-mist)] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--bio-green)]">{{ $produit->format }}</div>
                            <span class="kpi-chip">{{ $produit->stock_disponible }} en stock</span>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-stone-900">{{ $produit->nom }}</h3>
                        <p class="mt-3 text-sm leading-7 text-stone-600">{{ $produit->description }}</p>
                        <div class="mt-6 flex items-end justify-between">
                            <p class="text-3xl font-bold text-[var(--bio-green)]">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                            <span class="text-sm text-stone-500">unite</span>
                        </div>
                        <a href="{{ route('site.produits.show', $produit->slug) }}" class="mt-5 inline-flex text-sm font-semibold text-[var(--bio-green)]">Voir la fiche produit</a>
                        <form method="POST" action="{{ route('site.panier.store') }}" class="mt-6 flex items-center gap-3">
                            @csrf
                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                            <input type="number" name="quantite" min="1" value="1" class="input mt-0 w-24">
                            <button type="submit" class="btn-primary flex-1">Ajouter au panier</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-4">
            @foreach ($segments as $segment)
                <article class="section-card">
                    <p class="eyebrow">Usage</p>
                    <h3 class="mt-3 text-2xl font-bold text-stone-900">{{ $segment['titre'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-stone-600">{{ $segment['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="section-card bg-[linear-gradient(135deg,#fff_0%,#f4efe3_100%)]">
                <p class="eyebrow">Traction</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-900">Des indicateurs qui parlent autant au client qu’au partenaire.</h2>
                <div class="mt-6 grid gap-4">
                    @foreach ($milestones as $milestone)
                        <div class="flex items-center justify-between rounded-[1.6rem] bg-white/80 px-4 py-4 shadow-sm shadow-stone-200/40">
                            <span class="text-sm font-medium text-stone-500">{{ $milestone['label'] }}</span>
                            <span class="text-lg font-bold text-stone-900">{{ $milestone['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel-dark p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Commande guidee</p>
                <h3 class="mt-3 text-3xl font-bold">Une relation commerciale adaptee au terrain</h3>
                <p class="mt-4 text-white/75">Le site sert a preparer le besoin, puis la validation passe directement par WhatsApp avec l equipe. Cela permet de confirmer le volume, le delai et la disponibilite avant toute suite commerciale.</p>
                <a href="{{ route('site.contact') }}" class="btn-primary mt-6 inline-flex bg-white text-[var(--bio-green)] hover:bg-stone-100">Demander une offre</a>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1fr_1fr]">
            <div class="section-card">
                <p class="eyebrow">Approche</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-900">Une chaine de valeur courte, locale et pilotable</h2>
                <p class="mt-4 text-stone-600">Le projet combine approvisionnement en manioc, transformation, production journaliere, distribution locale et suivi des impacts. Cela permet d’ajuster les volumes sans perdre le controle sur la qualite, le cout ou les delais.</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[1.75rem] bg-stone-50 p-5">
                        <p class="text-sm font-semibold text-stone-500">Production actuelle</p>
                        <p class="mt-2 text-3xl font-bold text-[var(--bio-green)]">{{ number_format(config('biosachet.launch_capacity_per_day'), 0, ',', ' ') }}</p>
                        <p class="mt-2 text-sm text-stone-500">sachets par jour au lancement</p>
                    </div>
                    <div class="rounded-[1.75rem] bg-stone-50 p-5">
                        <p class="text-sm font-semibold text-stone-500">Clients deja servis</p>
                        <p class="mt-2 text-3xl font-bold text-[var(--bio-green)]">{{ $metrics['clients_served'] }}</p>
                        <p class="mt-2 text-sm text-stone-500">structures visibles dans la base demo</p>
                    </div>
                </div>
            </div>
            <div class="section-card">
                <p class="eyebrow">FAQ rapide</p>
                <div class="mt-5 space-y-4">
                    @foreach ($faq as $item)
                        <div class="rounded-[1.75rem] border border-stone-200 px-5 py-5">
                            <h3 class="text-lg font-bold text-stone-900">{{ $item['question'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">{{ $item['answer'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-marketing-layout>
