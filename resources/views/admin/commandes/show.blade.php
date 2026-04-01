<x-admin-layout title="Detail commande" heading="Detail commande">
    <div class="grid gap-6 xl:grid-cols-[0.7fr_1.3fr]">
        <div class="card p-6">
            <div class="flex items-start justify-between gap-4">
                <h2 class="text-xl font-bold">Informations</h2>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.commandes.devis', $commande) }}" class="btn-secondary py-2">Devis PDF</a>
                    @if (auth()->user()->hasAnyAdminRole([\App\Models\User::ADMIN_ROLE_SUPER_ADMIN, \App\Models\User::ADMIN_ROLE_OPERATIONS]))
                        <a href="{{ route('admin.commandes.edit', $commande) }}" class="btn-secondary py-2">Modifier</a>
                    @endif
                </div>
            </div>
            <div class="mt-5 space-y-3 text-sm">
                <p><span class="font-semibold">Reference:</span> {{ $commande->reference }}</p>
                <p><span class="font-semibold">Commande:</span> #{{ $commande->id }}</p>
                <p><span class="font-semibold">Client:</span> {{ $commande->client->nom }}</p>
                <p><span class="font-semibold">Statut:</span> {{ $commande->statut_label }}</p>
                <p><span class="font-semibold">Paiement:</span> {{ $commande->paiement_label }}</p>
                <p><span class="font-semibold">Methode:</span> {{ $commande->methode_paiement_label }}</p>
                <p><span class="font-semibold">Livraison:</span> {{ optional($commande->date_livraison)->format('d/m/Y') }}</p>
                <p><span class="font-semibold">Total paye:</span> {{ number_format($commande->total_paye, 0, ',', ' ') }} FCFA</p>
                <p><span class="font-semibold">Solde restant:</span> {{ number_format($commande->solde_restant, 0, ',', ' ') }} FCFA</p>
                <p><span class="font-semibold">Lien de suivi:</span> <a class="text-[var(--bio-green)]" href="{{ route('site.commande.suivi.show', $commande->suivi_token) }}" target="_blank">ouvrir</a></p>
            </div>
        </div>
        <div class="card p-6">
            <h2 class="text-xl font-bold">Produits</h2>
            <div class="mt-5 space-y-4">
                @foreach ($commande->produits as $produit)
                    <div class="flex items-center justify-between rounded-2xl bg-stone-50 px-4 py-4">
                        <div>
                            <p class="font-semibold">{{ $produit->nom }}</p>
                            <p class="text-sm text-stone-500">{{ $produit->format }} | Qte {{ $produit->pivot->quantite }}</p>
                        </div>
                        <p class="font-bold text-[var(--bio-green)]">{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-right text-2xl font-bold text-stone-900">Total: {{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="card p-6">
            <h2 class="text-xl font-bold">Historique des paiements</h2>
            <div class="mt-5 space-y-4">
                @forelse ($commande->paiements as $paiement)
                    <div class="rounded-2xl bg-stone-50 px-4 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-stone-900">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                                <p class="text-sm text-stone-500">{{ config('biosachet.payment_methods')[$paiement->methode_paiement] ?? $paiement->methode_paiement }} · {{ $paiement->date_paiement->format('d/m/Y') }}</p>
                                <p class="text-sm text-stone-500">Ref: {{ $paiement->reference_paiement ?: 'n/a' }} · Par {{ $paiement->creator?->name ?: 'systeme' }}</p>
                                @if ($paiement->note)
                                    <p class="mt-2 text-sm text-stone-600">{{ $paiement->note }}</p>
                                @endif
                            </div>
                            @if (auth()->user()->canAccessAdminSection('paiements'))
                                <form method="POST" action="{{ route('admin.commandes.paiements.destroy', [$commande, $paiement]) }}" onsubmit="return confirm('Supprimer ce paiement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-red-600">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucun paiement detaille enregistre.</p>
                @endforelse
            </div>
        </div>

        <div class="card p-6">
            <h2 class="text-xl font-bold">Enregistrer un paiement</h2>
            @if (auth()->user()->canAccessAdminSection('paiements'))
                <form method="POST" action="{{ route('admin.commandes.paiements.store', $commande) }}" class="mt-5 space-y-5">
                    @csrf
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="label" for="montant">Montant</label>
                            <input id="montant" type="number" step="0.01" min="1" name="montant" value="{{ old('montant', $commande->solde_restant) }}" class="input">
                        </div>
                        <div>
                            <label class="label" for="date_paiement">Date de paiement</label>
                            <input id="date_paiement" type="date" name="date_paiement" value="{{ old('date_paiement', now()->toDateString()) }}" class="input">
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="label" for="methode_paiement">Methode</label>
                            <select id="methode_paiement" name="methode_paiement" class="input">
                                @foreach (config('biosachet.payment_methods') as $value => $label)
                                    <option value="{{ $value }}" @selected(old('methode_paiement', $commande->methode_paiement) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label" for="reference_paiement">Reference</label>
                            <input id="reference_paiement" name="reference_paiement" value="{{ old('reference_paiement') }}" class="input" placeholder="FLOOZ-2026-0001">
                        </div>
                    </div>
                    <div>
                        <label class="label" for="note">Note</label>
                        <textarea id="note" name="note" rows="4" class="input">{{ old('note') }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary">Ajouter le paiement</button>
                </form>
            @else
                <p class="mt-5 text-sm text-stone-500">Votre profil n'autorise pas l'enregistrement des paiements.</p>
            @endif
        </div>
    </div>
</x-admin-layout>
