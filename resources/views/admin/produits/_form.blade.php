@php($identityLocked = $identityLocked ?? false)

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="label" for="nom">Nom</label>
        <input id="nom" name="nom" value="{{ old('nom', $produit->nom) }}" class="input" @if($identityLocked) readonly @endif required>
    </div>
    <div>
        <label class="label" for="slug">Slug</label>
        <input id="slug" name="slug" value="{{ old('slug', $produit->slug) }}" class="input" @if($identityLocked) readonly @endif required>
    </div>
    <div>
        <label class="label" for="format">Format</label>
        <input id="format" name="format" value="{{ old('format', $produit->format) }}" class="input" @if($identityLocked) readonly @endif required>
    </div>
    <div>
        <label class="label" for="usage_ideal">Usage ideal</label>
        <input id="usage_ideal" name="usage_ideal" value="{{ old('usage_ideal', $produit->usage_ideal) }}" class="input" required>
    </div>
    <div class="md:col-span-2">
        <label class="label" for="description">Description</label>
        <textarea id="description" name="description" rows="3" class="input">{{ old('description', $produit->description) }}</textarea>
    </div>
    <div>
        <label class="label" for="prix_unitaire">Prix unitaire</label>
        <input id="prix_unitaire" name="prix_unitaire" type="number" min="1" step="0.01" value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="cout_revient">Cout de revient</label>
        <input id="cout_revient" name="cout_revient" type="number" min="0" step="0.01" value="{{ old('cout_revient', $produit->cout_revient ?: 5) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="stock_disponible">Stock disponible</label>
        <input id="stock_disponible" name="stock_disponible" type="number" min="0" value="{{ old('stock_disponible', $produit->stock_disponible) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="proprietes_text">Proprietes</label>
        <input id="proprietes_text" name="proprietes_text" value="{{ old('proprietes_text', $produit->proprietes_text) }}" class="input" placeholder="Transparent, Souple, Resistant" required>
        @if ($produit->exists && $produit->badge_properties)
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($produit->badge_properties as $badge)
                    <span class="status-pill bg-stone-100 text-stone-700">{{ $badge }}</span>
                @endforeach
            </div>
        @endif
    </div>
    <div>
        <label class="label" for="sechage_heures_min">Sechage min</label>
        <input id="sechage_heures_min" name="sechage_heures_min" type="number" min="1" value="{{ old('sechage_heures_min', $produit->sechage_heures_min) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="sechage_heures_max">Sechage max</label>
        <input id="sechage_heures_max" name="sechage_heures_max" type="number" min="1" value="{{ old('sechage_heures_max', $produit->sechage_heures_max) }}" class="input" required>
    </div>
    <div class="md:col-span-2">
        <label class="label" for="recette_text">Recette</label>
        <textarea id="recette_text" name="recette_text" rows="6" class="input" placeholder="Amidon: 3 cuilleres&#10;Eau: 1 tasse" required>{{ old('recette_text', $produit->recette_lines) }}</textarea>
    </div>
    <div class="md:col-span-2">
        <label class="label" for="notes_production">Notes de production</label>
        <textarea id="notes_production" name="notes_production" rows="5" class="input">{{ old('notes_production', $produit->notes_production) }}</textarea>
    </div>
</div>
