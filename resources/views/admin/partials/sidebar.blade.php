<aside :class="navOpen ? 'translate-x-0 opacity-100' : '-translate-x-full opacity-0 md:translate-x-0 md:opacity-100'" class="fixed inset-y-0 left-0 z-40 w-80 transform overflow-y-auto border-r border-white/10 bg-[linear-gradient(180deg,#173618_0%,#102411_100%)] p-5 text-white transition duration-200 md:static md:min-h-screen md:translate-x-0 md:opacity-100">
    @php
        $user = auth()->user();
        $alerts = app(\App\Services\AlertService::class)->all();
        $alertCount = $alerts['count'];
        $links = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 13h8V3H3v10zm10 8h8V3h-8v18zM3 21h8v-6H3v6z', 'section' => 'dashboard', 'hint' => 'Vue globale'],
            ['label' => 'Produits', 'route' => 'admin.produits.index', 'icon' => 'M4 7h16M4 12h16M4 17h16', 'section' => 'produits', 'hint' => 'Catalogue et stock'],
            ['label' => 'Clients', 'route' => 'admin.clients.index', 'icon' => 'M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm8 8a3 3 0 1 0 0-6', 'section' => 'clients', 'hint' => 'Base client'],
            ['label' => 'Commandes', 'route' => 'admin.commandes.index', 'icon' => 'M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z', 'section' => 'commandes', 'hint' => 'Flux commercial'],
            ['label' => 'Productions', 'route' => 'admin.productions.index', 'icon' => 'M12 2 2 7l10 5 10-5-10-5zm0 9L2 6v11l10 5 10-5V6l-10 5z', 'section' => 'productions', 'hint' => 'Fabrication'],
            ['label' => 'Stock matiere', 'route' => 'admin.stocks-matieres.index', 'icon' => 'M20 7H4V5h16v2zm0 4H4v8h16v-8z', 'section' => 'stocks', 'hint' => 'Approvisionnements'],
            ['label' => 'Paiements', 'route' => 'admin.commandes.index', 'icon' => 'M12 8c-2.21 0-4 .896-4 2s1.79 2 4 2 4 .896 4 2-1.79 2-4 2m0 0c-2.21 0-4 .896-4 2s1.79 2 4 2 4 .896 4 2-1.79 2-4 2m0-8V4m0 16v-2', 'section' => 'paiements', 'hint' => 'Encaissements'],
            ['label' => 'Rapports', 'route' => 'admin.rapports.index', 'icon' => 'M4 19h16M7 16V8M12 16V5M17 16v-3', 'section' => 'rapports', 'hint' => 'Syntheses'],
            ['label' => 'Alertes', 'route' => 'admin.alertes.index', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z', 'section' => 'alertes', 'hint' => 'Points critiques'],
            ['label' => 'Journal', 'route' => 'admin.activites.index', 'icon' => 'M9 17v-6h13M9 5h13M9 11h13M3 5h.01M3 11h.01M3 17h.01', 'section' => 'activites', 'hint' => 'Traçabilite'],
            ['label' => 'Admins', 'route' => 'admin.admin-users.index', 'icon' => 'M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M8.5 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm9.5 8V9m-3 3h6', 'section' => 'admins', 'hint' => 'Roles et acces'],
        ];
    @endphp
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-[1.35rem] bg-white/10 text-sm font-bold text-white">BT</span>
            <span>
                <span class="block text-lg font-bold tracking-tight">BioSachet Admin</span>
                <span class="block text-xs uppercase tracking-[0.28em] text-white/55">Interne</span>
            </span>
        </a>
        <button type="button" @click="navOpen = false" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 text-white md:hidden">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="panel-dark mb-5 overflow-hidden border-white/10 bg-white/10 p-0">
        <div class="border-b border-white/10 px-5 py-4">
            <p class="text-xs uppercase tracking-[0.28em] text-white/55">Compte actif</p>
            <p class="mt-3 text-lg font-semibold">{{ $user->name }}</p>
            <p class="text-sm text-white/65">{{ $user->email }}</p>
        </div>
        <div class="grid grid-cols-2 gap-px bg-white/10">
            <div class="bg-white/5 px-5 py-4">
                <p class="text-xs uppercase tracking-[0.18em] text-white/50">Role</p>
                <p class="mt-2 text-sm font-semibold">{{ $user->admin_role_label }}</p>
            </div>
            <div class="bg-white/5 px-5 py-4">
                <p class="text-xs uppercase tracking-[0.18em] text-white/50">Alertes</p>
                <p class="mt-2 text-sm font-semibold">{{ $alertCount }} ouvertes</p>
            </div>
        </div>
    </div>

    <div class="mb-5 rounded-[1.6rem] border border-amber-300/20 bg-amber-400/10 px-5 py-4">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-white/55">Surveillance</p>
                <p class="mt-2 text-2xl font-bold">{{ $alertCount }}</p>
                <p class="mt-1 text-sm text-white/65">stocks, retards et impayes a suivre</p>
            </div>
            <a href="{{ route('admin.alertes.index') }}" class="rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white/80">Voir</a>
        </div>
    </div>

    <nav class="space-y-2">
        @foreach ($links as $link)
            @if ($user->canAccessAdminSection($link['section']))
                @php($active = request()->routeIs(str_replace('.index', '.*', $link['route'])) || request()->routeIs($link['route']))
                <a href="{{ route($link['route']) }}" @click="navOpen = false" class="admin-link {{ $active ? 'admin-link-active' : '' }}">
                    <span class="flex h-11 w-11 items-center justify-center rounded-[1rem] {{ $active ? 'bg-[var(--bio-mist)] text-[var(--bio-green)]' : 'bg-white/5 text-white/80' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                        </svg>
                    </span>
                    <span class="flex-1">
                        <span class="block">{{ $link['label'] }}</span>
                        <span class="block text-xs font-normal {{ $active ? 'text-[var(--bio-green)]/70' : 'text-white/45' }}">{{ $link['hint'] }}</span>
                    </span>
                </a>
            @endif
        @endforeach
    </nav>
</aside>
<div x-show="navOpen" x-transition.opacity @click="navOpen = false" class="fixed inset-0 z-30 bg-stone-950/45 md:hidden"></div>
