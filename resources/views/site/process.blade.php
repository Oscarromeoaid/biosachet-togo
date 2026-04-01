<x-marketing-layout title="BioSachet Togo | Notre processus">
    <section class="py-16">
        <div class="container-shell">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[var(--bio-green)]">Processus</p>
            <h1 class="mt-3 text-4xl font-bold text-stone-900">De l'amidon local au sachet compostable</h1>
            <div class="mt-10 grid gap-6 lg:grid-cols-5">
                @foreach ($steps as $index => $step)
                    <article class="card p-6">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[var(--bio-green)] text-lg font-bold text-white">{{ $index + 1 }}</div>
                        <h2 class="mt-5 text-xl font-bold">{{ $step['titre'] }}</h2>
                        <p class="mt-3 text-sm text-stone-600">{{ $step['description'] }}</p>
                        <p class="mt-3 text-sm leading-7 text-stone-500">{{ $step['detail'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="card p-8">
                <p class="eyebrow">Methode</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-900">Un flux de production pense pour apprendre vite et produire proprement</h2>
                <div class="mt-5 space-y-4 text-sm leading-7 text-stone-600">
                    <p>Le processus est volontairement simple: peu d etapes, un controle direct du lot, et une lecture immediate des volumes produits par format. Cela facilite le pilotage en debut d activite.</p>
                    <p>Le suivi journalier aide a relier la consommation de manioc, la sortie de sachets et la baisse du plastique evite. C est utile autant pour la gestion interne que pour la communication commerciale.</p>
                    <p>Cette base est suffisante pour une petite unite et reste compatible avec une montee en puissance vers une mini-factory mieux equipee.</p>
                </div>
            </div>
            <div class="card p-8">
                <p class="eyebrow">Qualite</p>
                <div class="mt-5 space-y-4">
                    @foreach ($qualityPoints as $point)
                        <div class="flex gap-3 rounded-2xl bg-stone-50 px-4 py-4">
                            <div class="mt-1 h-2.5 w-2.5 rounded-full bg-[var(--bio-green)]"></div>
                            <p class="text-sm leading-7 text-stone-600">{{ $point }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-marketing-layout>
