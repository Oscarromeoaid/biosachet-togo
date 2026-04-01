<x-marketing-layout title="BioSachet Togo | Commande confirmee">
    @php($confirmationWhatsappUrl = 'https://wa.me/'.config('biosachet.whatsapp').'?text='.rawurlencode('Bonjour, je confirme ma commande '.$confirmation['reference'].' au nom de '.$confirmation['nom'].'.'))
    <section class="py-20">
        <div class="container-shell max-w-4xl">
            <div class="card p-10 text-center">
                <p class="eyebrow">Commande recue</p>
                <h1 class="mt-4 text-4xl font-bold text-stone-900">Votre demande a ete enregistree</h1>
                <p class="mt-4 text-lg text-stone-600">Notre equipe va verifier le stock, confirmer le delai et vous recontacter rapidement.</p>

                <div class="mt-10 grid gap-4 md:grid-cols-2">
                    <div class="rounded-3xl bg-stone-50 px-5 py-5 text-left">
                        <p class="text-sm text-stone-500">Reference</p>
                        <p class="mt-2 text-2xl font-bold text-stone-900">{{ $confirmation['reference'] }}</p>
                    </div>
                    <div class="rounded-3xl bg-stone-50 px-5 py-5 text-left">
                        <p class="text-sm text-stone-500">Numero de commande</p>
                        <p class="mt-2 text-3xl font-bold text-[var(--bio-green)]">#{{ $confirmation['numero'] }}</p>
                    </div>
                    <div class="rounded-3xl bg-stone-50 px-5 py-5 text-left">
                        <p class="text-sm text-stone-500">Total estime</p>
                        <p class="mt-2 text-3xl font-bold text-[var(--bio-green)]">{{ number_format($confirmation['total'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="rounded-3xl bg-stone-50 px-5 py-5 text-left">
                        <p class="text-sm text-stone-500">Client</p>
                        <p class="mt-2 text-lg font-bold text-stone-900">{{ $confirmation['nom'] }}</p>
                        <p class="mt-1 text-sm text-stone-600">{{ $confirmation['telephone'] }}</p>
                    </div>
                    <div class="rounded-3xl bg-stone-50 px-5 py-5 text-left">
                        <p class="text-sm text-stone-500">Paiement prevu</p>
                        <p class="mt-2 text-lg font-bold text-stone-900">{{ $confirmation['methode_paiement'] }}</p>
                    </div>
                </div>

                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('site.produits') }}" class="btn-secondary">Continuer les achats</a>
                    <a href="{{ route('site.commande.suivi.show', $confirmation['suivi_token']) }}" class="btn-secondary">Suivre ma commande</a>
                    <a href="{{ route('site.commande.devis', $confirmation['suivi_token']) }}" class="btn-secondary">Telecharger le devis</a>
                    <a href="{{ $confirmationWhatsappUrl }}" target="_blank" rel="noopener" class="btn-primary">Confirmer sur WhatsApp</a>
                </div>
            </div>
        </div>
    </section>
</x-marketing-layout>
