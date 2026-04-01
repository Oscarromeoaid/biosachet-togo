<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="label" for="date_achat">Date d'achat</label>
        <input id="date_achat" name="date_achat" type="date" value="{{ old('date_achat', optional($stock->date_achat)->toDateString()) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="quantite_kg">Quantite (kg)</label>
        <input id="quantite_kg" name="quantite_kg" type="number" min="0.1" step="0.01" value="{{ old('quantite_kg', $stock->quantite_kg) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="cout_total">Cout total</label>
        <input id="cout_total" name="cout_total" type="number" min="0" step="0.01" value="{{ old('cout_total', $stock->cout_total) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="fournisseur">Fournisseur</label>
        <input id="fournisseur" name="fournisseur" value="{{ old('fournisseur', $stock->fournisseur) }}" class="input" required>
    </div>
</div>
