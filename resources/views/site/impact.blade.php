<x-marketing-layout title="BioSachet Togo | Impact environnemental">
    <section class="py-16">
        <div class="container-shell">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[var(--bio-green)]">Impact</p>
            <h1 class="mt-3 text-4xl font-bold text-stone-900">Des donnees qui mesurent le changement</h1>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="card p-7">
                    <p class="text-sm text-stone-500">Plastique evite</p>
                    <p class="mt-4 text-4xl font-bold text-[var(--bio-green)]">{{ number_format($metrics['plastic_avoided_kg'], 2, ',', ' ') }}</p>
                    <p class="mt-2 text-sm text-stone-500">kg equivalents</p>
                </div>
                <div class="card p-7">
                    <p class="text-sm text-stone-500">Sachets produits ce mois</p>
                    <p class="mt-4 text-4xl font-bold text-stone-900">{{ number_format($metrics['sachets_produced_this_month'], 0, ',', ' ') }}</p>
                </div>
                <div class="card p-7">
                    <p class="text-sm text-stone-500">Emplois soutenus</p>
                    <p class="mt-4 text-4xl font-bold text-stone-900">{{ $metrics['jobs_created'] }}</p>
                </div>
                <div class="card p-7">
                    <p class="text-sm text-stone-500">Ecoles partenaires</p>
                    <p class="mt-4 text-4xl font-bold text-stone-900">{{ $metrics['partner_schools'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-3">
            @foreach ($pillars as $pillar)
                <article class="card p-8">
                    <p class="eyebrow">Pilier</p>
                    <h2 class="mt-3 text-2xl font-bold text-stone-900">{{ $pillar['titre'] }}</h2>
                    <p class="mt-4 text-sm leading-7 text-stone-600">{{ $pillar['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="card p-8">
                <p class="eyebrow">Lecture des chiffres</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-900">Des indicateurs utiles pour l equipe, les partenaires et les prospects</h2>
                <div class="mt-5 space-y-4 text-sm leading-7 text-stone-600">
                    <p>Le tableau de bord suit les volumes produits, les ventes, le stock de manioc et le plastique evite. Cela rend l impact visible sans sortir de l exploitation quotidienne.</p>
                    <p>Les donnees permettent aussi de preparer des rapports simples pour les ONG, les partenaires financiers ou les institutions qui demandent des preuves de traction.</p>
                    <p>Dans la demo admin, ces indicateurs sont deja relies aux productions, commandes et achats de matiere premiere pour offrir un rendu credible.</p>
                </div>
            </div>
            <div class="card p-8">
                <p class="eyebrow">Objectifs</p>
                <div class="mt-5 space-y-4">
                    @foreach ($targets as $target)
                        <div class="rounded-2xl bg-stone-50 px-4 py-4">
                            <p class="text-sm font-semibold text-stone-500">{{ $target['label'] }}</p>
                            <p class="mt-2 text-lg font-bold text-stone-900">{{ $target['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-marketing-layout>
