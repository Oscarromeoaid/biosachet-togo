<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BioSachet Togo') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,#dfe8cf_0%,#f5f2e8_45%,#efe7d4_100%)]">
    <div class="pointer-events-none fixed inset-0 opacity-40 soft-grid"></div>
    <div class="container-shell flex min-h-screen items-center justify-center py-10">
        <div class="grid w-full max-w-6xl overflow-hidden rounded-[2.25rem] border border-white/60 bg-white/80 shadow-2xl shadow-stone-300/50 backdrop-blur-xl lg:grid-cols-[1.2fr_0.8fr]">
            <div class="relative hidden overflow-hidden bg-[linear-gradient(180deg,#173618_0%,#2c5f2d_58%,#7ba05b_100%)] p-10 text-white lg:block">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_34%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.12),transparent_28%)]"></div>
                <div class="relative">
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-white/70">BioSachet Togo</p>
                    <h1 class="mt-6 max-w-md text-4xl font-bold leading-tight">{{ config('biosachet.tagline') }}</h1>
                    <p class="mt-6 max-w-md text-base text-white/80">Administration des produits, commandes, productions, paiements et alertes environnementales.</p>
                    <div class="mt-10 grid gap-4">
                        <div class="glass-panel p-5">
                            <p class="text-xs uppercase tracking-[0.22em] text-white/60">Pilotage</p>
                            <p class="mt-3 text-2xl font-bold">Back-office structure</p>
                            <p class="mt-2 text-sm text-white/75">Roles, journaux, stocks et paiements sur une interface unique.</p>
                        </div>
                        <div class="glass-panel p-5">
                            <p class="text-xs uppercase tracking-[0.22em] text-white/60">Terrain</p>
                            <p class="mt-3 text-2xl font-bold">Vue operationnelle</p>
                            <p class="mt-2 text-sm text-white/75">Commandes, livraison, stock de manioc et suivi des alertes en temps reel.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative p-8 sm:p-12">
                <div class="absolute right-8 top-8 hidden h-16 w-16 rounded-[1.5rem] bg-[linear-gradient(135deg,rgba(123,160,91,0.28),rgba(44,95,45,0.14))] lg:block"></div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
