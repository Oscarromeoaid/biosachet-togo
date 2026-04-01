<div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
    <div class="space-y-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="label" for="date">Date</label>
                <input id="date" name="date" type="date" value="{{ old('date', optional($production->date)->toDateString()) }}" class="input" required>
            </div>
            <div>
                <label class="label" for="kg_manioc_utilise">Kg de manioc utilises</label>
                <input id="kg_manioc_utilise" name="kg_manioc_utilise" type="number" min="0.1" step="0.01" value="{{ old('kg_manioc_utilise', $production->kg_manioc_utilise) }}" class="input" required>
            </div>
            <div>
                <label class="label" for="sachets_petit_transparent">Petit sachet transparent</label>
                <input id="sachets_petit_transparent" name="sachets_petit_transparent" type="number" min="0" value="{{ old('sachets_petit_transparent', $production->sachets_petit_transparent) }}" class="input" required>
            </div>
            <div>
                <label class="label" for="sachets_moyen_souple">Sachet moyen souple</label>
                <input id="sachets_moyen_souple" name="sachets_moyen_souple" type="number" min="0" value="{{ old('sachets_moyen_souple', $production->sachets_moyen_souple) }}" class="input" required>
            </div>
            <div>
                <label class="label" for="sachets_grand_solide">Grand sachet epais et solide</label>
                <input id="sachets_grand_solide" name="sachets_grand_solide" type="number" min="0" value="{{ old('sachets_grand_solide', $production->sachets_grand_solide) }}" class="input" required>
            </div>
            <div>
                <label class="label" for="film_biodegradable_m2">Film biodegradable (m2)</label>
                <input id="film_biodegradable_m2" name="film_biodegradable_m2" type="number" min="0" step="0.01" value="{{ old('film_biodegradable_m2', $production->film_biodegradable_m2) }}" class="input" required>
            </div>
            <div class="md:col-span-2">
                <label class="label" for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="4" class="input">{{ old('notes', $production->notes) }}</textarea>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="section-card">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Reference recette</p>
            <h3 class="mt-2 text-2xl font-bold text-stone-900">Rappels rapides par type</h3>
            <p class="mt-2 text-sm text-stone-500">Ces cartes servent d aide pendant la saisie quotidienne de production.</p>
        </div>

        @foreach ($produitsReference as $produit)
            <div class="section-card">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h4 class="text-lg font-bold text-stone-900">{{ $produit->nom }}</h4>
                        <p class="text-sm text-stone-500">{{ $produit->usage_ideal }}</p>
                    </div>
                    <span class="kpi-chip">{{ $produit->sechage_label }}</span>
                </div>

                <ul class="mt-4 space-y-2 text-sm text-stone-600">
                    @foreach ($produit->recette ?? [] as $ingredient => $quantite)
                        <li>{{ $ingredient }}: {{ $quantite }}</li>
                    @endforeach
                </ul>

                @if ($produit->notes_production)
                    <div class="mt-4 rounded-[1.4rem] bg-stone-50 px-4 py-4 text-sm leading-7 text-stone-600">
                        {{ $produit->notes_production }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
