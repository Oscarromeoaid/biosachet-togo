<x-guest-layout>
    <div class="relative">
        <div class="mb-8">
            <p class="kpi-chip">Connexion admin</p>
            <h2 class="mt-4 text-3xl font-bold text-stone-900">Acceder au tableau de bord</h2>
            <p class="mt-3 max-w-md text-sm leading-7 text-stone-500">Acces reserve aux comptes internes. Les actions visibles changent selon le role: operations, finance ou super admin.</p>
        </div>

        <div class="mb-8 grid gap-3 sm:grid-cols-3">
            <div class="metric-band p-4">
                <p class="text-xs uppercase tracking-[0.22em] text-stone-500">Roles</p>
                <p class="mt-2 text-lg font-bold text-[var(--bio-green)]">3 profils</p>
            </div>
            <div class="metric-band p-4">
                <p class="text-xs uppercase tracking-[0.22em] text-stone-500">Securite</p>
                <p class="mt-2 text-lg font-bold text-[var(--bio-green)]">Acces filtre</p>
            </div>
            <div class="metric-band p-4">
                <p class="text-xs uppercase tracking-[0.22em] text-stone-500">Suivi</p>
                <p class="mt-2 text-lg font-bold text-[var(--bio-green)]">Journalise</p>
            </div>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="section-card space-y-5 p-0 shadow-none">
            @csrf

            <div>
                <label for="email" class="label">Adresse email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="label">Mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="input">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <label class="flex items-center gap-3 text-sm text-stone-600">
                <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-[var(--bio-green)]" name="remember">
                <span>Se souvenir de moi</span>
            </label>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-[var(--bio-green)]" href="{{ route('password.request') }}">
                        Mot de passe oublie ?
                    </a>
                @endif

                <button type="submit" class="btn-primary">Se connecter</button>
            </div>
        </form>
    </div>
</x-guest-layout>
