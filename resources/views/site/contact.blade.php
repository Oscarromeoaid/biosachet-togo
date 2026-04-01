<x-marketing-layout title="BioSachet Togo | Contact">
    @php($contactWhatsappUrl = 'https://wa.me/'.config('biosachet.whatsapp').'?text='.rawurlencode('Bonjour, je souhaite discuter de mon besoin en sachets biodegradables BioSachet Togo.'))
    <section class="py-16">
        <div class="container-shell grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="card p-8">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[var(--bio-green)]">Contact</p>
                <h1 class="mt-3 text-4xl font-bold text-stone-900">Parlons de votre besoin</h1>
                <p class="mt-4 text-stone-600">Commandes recurrentes, sachets sur mesure, partenariats ONG ou distribution grossiste: BioSachet Togo repond sous 24h ouvrees.</p>
                <div class="mt-8 space-y-3 text-sm text-stone-700">
                    @foreach ($channels as $channel)
                        <div class="rounded-2xl bg-stone-50 px-4 py-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">{{ $channel['label'] }}</p>
                            <p class="mt-2 font-semibold text-stone-900">{{ $channel['value'] }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ $contactWhatsappUrl }}" target="_blank" rel="noopener" class="btn-primary mt-8">Ecrire sur WhatsApp</a>
            </div>

            <div class="card p-8">
                <form method="POST" action="{{ route('site.contact.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="nom" class="label">Nom</label>
                        <input id="nom" name="nom" value="{{ old('nom') }}" class="input" required>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="telephone" class="label">Telephone</label>
                            <input id="telephone" name="telephone" value="{{ old('telephone') }}" class="input">
                        </div>
                        <div>
                            <label for="email" class="label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input">
                        </div>
                    </div>
                    <div>
                        <label for="message" class="label">Message</label>
                        <textarea id="message" name="message" rows="6" class="input" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary">Envoyer le message</button>
                </form>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container-shell grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="card p-8">
                <p class="eyebrow">Comment ca se passe</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-900">Du premier message a la livraison</h2>
                <div class="mt-6 space-y-4">
                    @foreach ($quoteSteps as $index => $step)
                        <div class="flex gap-4 rounded-3xl bg-stone-50 px-5 py-5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[var(--bio-green)] text-sm font-bold text-white">{{ $index + 1 }}</div>
                            <p class="text-sm leading-7 text-stone-600">{{ $step }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card p-8">
                <p class="eyebrow">Questions frequentes</p>
                <div class="mt-5 space-y-4">
                    @foreach ($faq as $item)
                        <div class="rounded-3xl border border-stone-200 px-5 py-5">
                            <h3 class="text-lg font-bold text-stone-900">{{ $item['question'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-stone-600">{{ $item['answer'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-marketing-layout>
