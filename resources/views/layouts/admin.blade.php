<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Administration BioSachet Togo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body x-data="{ navOpen: false }" class="bg-stone-100 text-stone-900">
    <div class="pointer-events-none fixed inset-0 opacity-35 soft-grid"></div>
    <div class="min-h-screen md:flex">
        @include('admin.partials.sidebar')

        <div class="relative flex-1">
            <div class="border-b border-white/70 bg-white/70 backdrop-blur-2xl">
                <div class="container-shell flex items-center justify-between gap-4 py-5">
                    <div>
                        <p class="kpi-chip">Back-office</p>
                        <h1 class="mt-3 text-2xl font-bold text-[var(--bio-green)] sm:text-3xl">{{ $heading ?? 'Administration' }}</h1>
                        <p class="mt-1 text-sm text-stone-500">Pilotage de la production, des ventes, du stock et des alertes.</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <button type="button" @click="navOpen = ! navOpen" class="inline-flex h-11 w-11 items-center justify-center rounded-[1.35rem] border border-white/70 bg-white/80 text-[var(--bio-green)] shadow-lg shadow-stone-200/40 md:hidden">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </button>
                        <span class="hidden rounded-full border border-white/70 bg-white/80 px-4 py-2 font-semibold text-stone-700 shadow-sm shadow-stone-200/40 sm:inline-flex">{{ auth()->user()->name }} · {{ auth()->user()->admin_role_label }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-secondary py-2">Deconnexion</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container-shell py-8">
                @include('admin.partials.flash')
                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
