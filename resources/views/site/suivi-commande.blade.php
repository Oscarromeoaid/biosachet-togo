<x-marketing-layout title="BioSachet Togo | Suivi de commande">
    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="card p-8">
                <p class="eyebrow">Suivi public</p>
                <h1 class="mt-3 text-4xl font-bold text-stone-900">Retrouver une commande</h1>
                <p class="mt-4 text-stone-600">Saisissez la reference de commande et le numero de telephone utilise au moment de la demande.</p>

                <form method="POST" action="{{ route('site.commande.lookup') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label for="reference" class="label">Reference de commande</label>
                        <input id="reference" name="reference" value="{{ old('reference', $commande?->reference) }}" class="input" placeholder="BST-20260331-00042" required>
                    </div>
                    <div>
                        <label for="telephone" class="label">Telephone</label>
                        <input id="telephone" name="telephone" value="{{ old('telephone', $commande?->client?->telephone) }}" class="input" placeholder="90112233" required>
                    </div>
                    <button type="submit" class="btn-primary w-full">Rechercher la commande</button>
                </form>
            </div>

            <div class="card p-8">
                @if ($commande)
                    @php($trackingWhatsappUrl = 'https://wa.me/'.config('biosachet.whatsapp').'?text='.rawurlencode('Bonjour, je souhaite un suivi pour la commande '.$commande->reference.'.'))
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="eyebrow">Commande trouvee</p>
                            <h2 class="mt-3 text-3xl font-bold text-stone-900">{{ $commande->reference }}</h2>
                            <p class="mt-2 text-stone-600">{{ $commande->client->nom }} · {{ $commande->client->telephone }}</p>
                        </div>
                        <span class="rounded-full bg-[var(--bio-cream)] px-4 py-2 text-sm font-semibold text-[var(--bio-green)]">{{ $commande->statut_label }}</span>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-2">
                        <div class="rounded-3xl bg-stone-50 px-5 py-5">
                            <p class="text-sm text-stone-500">Paiement</p>
                            <p class="mt-2 text-lg font-bold text-stone-900">{{ $commande->paiement_label }}</p>
                            <p class="mt-1 text-sm text-stone-600">{{ $commande->methode_paiement_label }}</p>
                        </div>
                        <div class="rounded-3xl bg-stone-50 px-5 py-5">
                            <p class="text-sm text-stone-500">Livraison prevue</p>
                            <p class="mt-2 text-lg font-bold text-stone-900">{{ optional($commande->date_livraison)->format('d/m/Y') ?: 'A confirmer' }}</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @foreach ($commande->produits as $produit)
                            <div class="flex items-center justify-between rounded-3xl border border-stone-200 bg-white px-5 py-5">
                                <div>
                                    <p class="font-bold text-stone-900">{{ $produit->nom }}</p>
                                    <p class="mt-1 text-sm text-stone-500">{{ $produit->format }} · Quantite {{ $produit->pivot->quantite }}</p>
                                </div>
                                <p class="text-lg font-bold text-[var(--bio-green)]">{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 rounded-3xl bg-[var(--bio-green)] px-6 py-5 text-white">
                        <div>
                            <p class="text-sm text-white/75">Total</p>
                            <p class="mt-1 text-3xl font-bold">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('site.commande.devis', $commande->suivi_token) }}" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-[var(--bio-green)]">Telecharger le devis</a>
                            <a href="{{ $trackingWhatsappUrl }}" target="_blank" rel="noopener" class="rounded-full border border-white/30 px-5 py-3 text-sm font-semibold text-white">Contacter l'equipe</a>
                        </div>
                    </div>
                @else
                    <div class="flex h-full items-center justify-center rounded-3xl border border-dashed border-stone-300 bg-stone-50 px-6 py-16 text-center">
                        <div>
                            <h2 class="text-2xl font-bold text-stone-900">Aucune commande chargee</h2>
                            <p class="mt-3 max-w-md text-stone-600">Utilisez le formulaire a gauche ou le lien de suivi recu apres votre commande pour afficher les details.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-marketing-layout>
