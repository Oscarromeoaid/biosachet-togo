<x-marketing-layout title="BioSachet Togo | Panier">
    <section class="py-16">
        <div class="container-shell">
            <p class="eyebrow">Commande via WhatsApp</p>
            <h1 class="mt-3 text-4xl font-bold text-stone-900">Votre panier</h1>
            <p class="mt-4 max-w-3xl text-lg text-stone-600">Ajoutez vos formats, ajustez les quantites, puis envoyez votre demande sur WhatsApp. Aucun paiement ni validation de commande ne se fait en ligne.</p>
        </div>
    </section>

    <section class="pb-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="card p-8">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-2xl font-bold text-stone-900">Produits selectionnes</h2>
                    <span class="rounded-full bg-[var(--bio-cream)] px-4 py-2 text-sm font-semibold text-[var(--bio-green)]">{{ $cartCount }} article(s)</span>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse ($cartItems as $item)
                        <div class="rounded-3xl border border-stone-200 bg-stone-50 p-5">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <p class="text-lg font-bold text-stone-900">{{ $item['produit']->nom }}</p>
                                    <p class="mt-1 text-sm text-stone-500">{{ $item['produit']->format }} · {{ number_format($item['produit']->prix_unitaire, 0, ',', ' ') }} FCFA / unite</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-stone-500">Sous-total</p>
                                    <p class="text-2xl font-bold text-[var(--bio-green)]">{{ number_format($item['sous_total'], 0, ',', ' ') }} FCFA</p>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <form method="POST" action="{{ route('site.panier.update', $item['produit']) }}" class="flex items-center gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <label class="label" for="quantite-{{ $item['produit']->id }}">Quantite</label>
                                    <input id="quantite-{{ $item['produit']->id }}" type="number" name="quantite" min="1" value="{{ $item['quantite'] }}" class="input mt-0 w-24">
                                    <button type="submit" class="btn-secondary py-2">Mettre a jour</button>
                                </form>

                                <form method="POST" action="{{ route('site.panier.destroy', $item['produit']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-red-600">Retirer</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-12 text-center">
                            <h2 class="text-2xl font-bold text-stone-900">Votre panier est vide</h2>
                            <p class="mt-3 text-stone-600">Commencez par ajouter un ou plusieurs produits depuis le catalogue.</p>
                            <a href="{{ route('site.produits') }}" class="btn-primary mt-6">Voir les produits</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card p-8">
                <h2 class="text-2xl font-bold text-stone-900">Preparer le message WhatsApp</h2>
                <div class="mt-5 rounded-3xl bg-[var(--bio-cream)] px-5 py-5">
                    <p class="text-sm text-stone-500">Total estime</p>
                    <p class="mt-2 text-4xl font-bold text-[var(--bio-green)]">{{ number_format($cartTotal, 0, ',', ' ') }} FCFA</p>
                    <p class="mt-3 text-sm text-stone-500">Le montant reste estimatif jusqu'a confirmation manuelle sur WhatsApp.</p>
                </div>

                <form method="POST" action="{{ route('site.commande.store') }}" class="mt-6 space-y-5">
                    @csrf
                    <div>
                        <label for="nom" class="label">Nom ou structure</label>
                        <input id="nom" name="nom" value="{{ old('nom') }}" class="input" required>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="telephone" class="label">Telephone</label>
                            <input id="telephone" name="telephone" value="{{ old('telephone') }}" class="input" required>
                        </div>
                        <div>
                            <label for="email" class="label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input">
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="type" class="label">Type de client</label>
                            <select id="type" name="type" class="input" required>
                                <option value="">Choisir</option>
                                @foreach ($typesClient as $type)
                                    <option value="{{ $type }}" @selected(old('type') === $type)>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="ville" class="label">Ville</label>
                            <input id="ville" name="ville" value="{{ old('ville', 'Lome') }}" class="input" required>
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="date_livraison" class="label">Date de livraison souhaitee</label>
                            <input id="date_livraison" type="date" name="date_livraison" value="{{ old('date_livraison') }}" class="input">
                        </div>
                    </div>
                    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                        La demande sera ouverte directement dans WhatsApp avec vos coordonnees et le detail du panier.
                    </div>
                    <button type="submit" class="btn-primary w-full" @disabled($cartCount === 0)>Continuer sur WhatsApp</button>
                </form>
            </div>
        </div>
    </section>
</x-marketing-layout>
