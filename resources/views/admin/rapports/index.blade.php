<x-admin-layout title="Rapports" heading="Rapports">
    <div class="grid gap-6 xl:grid-cols-3">
        <div class="card p-6">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-[var(--bio-green)]">Impact environnemental</p>
            <h2 class="mt-3 text-2xl font-bold">Synthese impact</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Plastique evite</p>
                    <p class="mt-2 text-2xl font-bold">{{ number_format($impact['plastic_avoided_kg'], 2, ',', ' ') }} kg</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Clients servis</p>
                    <p class="mt-2 text-2xl font-bold">{{ $impact['clients_served'] }}</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Sachets produits</p>
                    <p class="mt-2 text-2xl font-bold">{{ number_format($impact['sachets_produced_this_month'], 0, ',', ' ') }}</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Film biodegradable</p>
                    <p class="mt-2 text-2xl font-bold">{{ number_format($impact['film_biodegradable_m2_this_month'], 2, ',', ' ') }} m2</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Ecoles partenaires</p>
                    <p class="mt-2 text-2xl font-bold">{{ $impact['partner_schools'] }}</p>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('admin.rapports.impact.pdf') }}" class="btn-primary">Exporter PDF</a>
                <a href="{{ route('admin.rapports.impact.excel') }}" class="btn-secondary">Exporter Excel</a>
            </div>
        </div>

        <div class="card p-6">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-[var(--bio-green)]">Finance</p>
            <h2 class="mt-3 text-2xl font-bold">Resume financier</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Revenus</p>
                    <p class="mt-2 text-2xl font-bold">{{ number_format($financial['revenue'], 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Couts</p>
                    <p class="mt-2 text-2xl font-bold">{{ number_format($financial['costs'], 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4 sm:col-span-2">
                    <p class="text-sm text-stone-500">Profit net</p>
                    <p class="mt-2 text-3xl font-bold text-[var(--bio-green)]">{{ number_format($financial['net_profit'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('admin.rapports.finance.pdf') }}" class="btn-primary">Exporter PDF</a>
                <a href="{{ route('admin.rapports.finance.excel') }}" class="btn-secondary">Exporter Excel</a>
            </div>
        </div>

        <div class="card p-6">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-[var(--bio-green)]">Production</p>
            <h2 class="mt-3 text-2xl font-bold">Production par type</h2>
            <div class="mt-6 grid gap-4">
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Perimetre</p>
                    <p class="mt-2 text-base font-semibold text-stone-900">Petit transparent, moyen souple, grand solide et film mesure en m2.</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Film du mois</p>
                    <p class="mt-2 text-2xl font-bold">{{ number_format($impact['film_biodegradable_m2_this_month'], 2, ',', ' ') }} m2</p>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('admin.rapports.production-types.excel') }}" class="btn-primary">Exporter Excel</a>
                <a href="{{ route('admin.rapports.production-types.csv') }}" class="btn-secondary">Exporter CSV</a>
            </div>
        </div>
    </div>
</x-admin-layout>
