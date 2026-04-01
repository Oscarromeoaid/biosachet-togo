<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'BioSachet Togo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--bio-cream)] text-[var(--bio-text)]">
    @php($genericWhatsappUrl = 'https://wa.me/'.config('biosachet.whatsapp').'?text='.rawurlencode('Bonjour, je souhaite en savoir plus sur les sachets biodegradables BioSachet Togo.'))
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[44rem] bg-[radial-gradient(circle_at_top_right,rgba(123,160,91,0.2),transparent_34%),radial-gradient(circle_at_top_left,rgba(44,95,45,0.16),transparent_30%),linear-gradient(180deg,rgba(255,255,255,0.85),rgba(245,242,232,0.65))]"></div>
    <div class="pointer-events-none absolute inset-0 -z-20 opacity-40 soft-grid"></div>
    <header x-data="{ open: false }" class="sticky top-0 z-30 border-b border-white/60 bg-white/70 backdrop-blur-2xl">
        <div class="container-shell py-4">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('site.home') }}" class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-[1.35rem] bg-[linear-gradient(135deg,#173618_0%,#2c5f2d_72%,#7ba05b_100%)] text-sm font-bold text-white shadow-lg shadow-emerald-950/20">BT</span>
                    <span>
                        <span class="block text-lg font-bold tracking-tight text-[var(--bio-green)]">BioSachet Togo</span>
                        <span class="block text-xs uppercase tracking-[0.26em] text-stone-500">Biodegradable</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-2 rounded-full border border-white/70 bg-white/75 px-3 py-2 text-sm font-semibold shadow-lg shadow-stone-200/30 md:flex">
                    <a href="{{ route('site.produits') }}" class="rounded-full px-4 py-2 transition hover:bg-[var(--bio-mist)] hover:text-[var(--bio-green)]">Produits</a>
                    <a href="{{ route('site.process') }}" class="rounded-full px-4 py-2 transition hover:bg-[var(--bio-mist)] hover:text-[var(--bio-green)]">Notre processus</a>
                    <a href="{{ route('site.impact') }}" class="rounded-full px-4 py-2 transition hover:bg-[var(--bio-mist)] hover:text-[var(--bio-green)]">Impact</a>
                    <a href="{{ route('site.contact') }}" class="rounded-full px-4 py-2 transition hover:bg-[var(--bio-mist)] hover:text-[var(--bio-green)]">Contact</a>
                    <a href="{{ route('site.commande.suivi') }}" class="rounded-full px-4 py-2 transition hover:bg-[var(--bio-mist)] hover:text-[var(--bio-green)]">Suivi</a>
                    <a href="{{ route('site.panier') }}" class="rounded-full px-4 py-2 transition hover:bg-[var(--bio-mist)] hover:text-[var(--bio-green)]">Panier @if(($cartCount ?? 0) > 0)<span class="ml-1 rounded-full bg-[var(--bio-green)] px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>@endif</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ $genericWhatsappUrl }}" target="_blank" rel="noopener" class="hidden sm:inline-flex btn-primary py-2">WhatsApp</a>
                    <button type="button" @click="open = ! open" class="inline-flex h-11 w-11 items-center justify-center rounded-[1.35rem] border border-white/70 bg-white/80 text-[var(--bio-green)] shadow-lg shadow-stone-200/40 md:hidden">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="open" x-transition class="mt-4 space-y-3 rounded-[2rem] border border-white/70 bg-white/90 p-4 shadow-xl shadow-stone-200/40 backdrop-blur md:hidden">
                <a href="{{ route('site.produits') }}" class="block rounded-2xl px-4 py-3 font-semibold text-stone-700 hover:bg-stone-50">Produits</a>
                <a href="{{ route('site.process') }}" class="block rounded-2xl px-4 py-3 font-semibold text-stone-700 hover:bg-stone-50">Notre processus</a>
                <a href="{{ route('site.impact') }}" class="block rounded-2xl px-4 py-3 font-semibold text-stone-700 hover:bg-stone-50">Impact</a>
                <a href="{{ route('site.contact') }}" class="block rounded-2xl px-4 py-3 font-semibold text-stone-700 hover:bg-stone-50">Contact</a>
                <a href="{{ route('site.commande.suivi') }}" class="block rounded-2xl px-4 py-3 font-semibold text-stone-700 hover:bg-stone-50">Suivi</a>
                <a href="{{ route('site.panier') }}" class="block rounded-2xl px-4 py-3 font-semibold text-stone-700 hover:bg-stone-50">Panier @if(($cartCount ?? 0) > 0)<span class="ml-1 rounded-full bg-[var(--bio-green)] px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>@endif</a>
                <a href="{{ $genericWhatsappUrl }}" target="_blank" rel="noopener" class="btn-primary w-full py-2">WhatsApp</a>
            </div>
        </div>
    </header>

    <main>
        @if (session('success'))
            <div class="container-shell mt-6">
                <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="container-shell mt-6">
                <div class="rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="mt-20 border-t border-white/20 bg-[linear-gradient(180deg,#173618_0%,#102411_100%)] py-14 text-stone-100">
        <div class="container-shell grid gap-8 md:grid-cols-[1.1fr_1fr_1fr]">
            <div>
                <h3 class="text-lg font-semibold">BioSachet Togo</h3>
                <p class="mt-3 max-w-sm text-sm text-stone-300">{{ config('biosachet.tagline') }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Contact</h3>
                <p class="mt-3 text-sm text-stone-300">{{ config('biosachet.adresse') }}</p>
                <p class="text-sm text-stone-300">{{ config('biosachet.telephone') }}</p>
                <p class="text-sm text-stone-300">{{ config('biosachet.email') }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Prise de commande</h3>
                <p class="mt-3 text-sm text-stone-300">Les demandes passent d abord par WhatsApp pour confirmer volume, delai et disponibilite avant toute suite.</p>
                <a href="{{ route('site.commande.suivi') }}" class="mt-3 inline-flex text-sm font-semibold text-white">Suivre une commande</a>
            </div>
        </div>
    </footer>
</body>
</html>
