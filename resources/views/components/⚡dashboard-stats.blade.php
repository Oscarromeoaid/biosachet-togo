<?php

use App\Services\DashboardMetricsService;
use Livewire\Component;

new class extends Component
{
    public array $stats = [];

    public function mount(): void
    {
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->stats = app(DashboardMetricsService::class)->get();
    }
};
?>

<div wire:poll.30s="refreshStats" class="space-y-6">
    <div class="grid gap-4 lg:grid-cols-[1.35fr_0.65fr]">
        <div class="panel-dark relative overflow-hidden p-7">
            <div class="absolute inset-y-0 right-0 w-1/2 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.16),transparent_55%)]"></div>
            <div class="relative">
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/60">Vue du jour</p>
                <h2 class="mt-3 max-w-xl text-3xl font-bold leading-tight">Le back-office suit la production, les commandes et les alertes sans changer d’ecran.</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/55">CA du mois</p>
                        <p class="mt-3 text-2xl font-bold">{{ number_format($stats['monthly_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/55">Commandes en attente</p>
                        <p class="mt-3 text-2xl font-bold">{{ $stats['pending_orders'] ?? 0 }}</p>
                    </div>
                    <div class="glass-panel p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/55">Clients servis</p>
                        <p class="mt-3 text-2xl font-bold">{{ $stats['clients_served'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-card flex flex-col justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Alerte manioc</p>
                <p class="mt-3 text-3xl font-bold {{ ($stats['cassava_alert'] ?? false) ? 'text-red-600' : 'text-[var(--bio-green)]' }}">{{ number_format($stats['cassava_stock_kg'] ?? 0, 2, ',', ' ') }} kg</p>
                <p class="mt-2 text-sm leading-6 text-stone-500">Stock restant calcule a partir des achats et de la consommation de production.</p>
            </div>
            <div class="mt-5 rounded-[1.4rem] px-4 py-4 {{ ($stats['cassava_alert'] ?? false) ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">
                @if ($stats['cassava_alert'] ?? false)
                    <p class="font-semibold">Seuil critique atteint. Reapprovisionnement a planifier.</p>
                @else
                    <p class="font-semibold">Le stock reste au-dessus du seuil d’alerte.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
        <div class="stat-tile">
            <p class="text-sm text-stone-500">Sachets produits ce mois</p>
            <p class="mt-3 text-3xl font-bold text-stone-900">{{ number_format($stats['sachets_produced_this_month'] ?? 0, 0, ',', ' ') }}</p>
            <p class="mt-2 text-sm text-stone-500">capacite reelle enregistree</p>
        </div>
        <div class="stat-tile">
            <p class="text-sm text-stone-500">Film biodegradable</p>
            <p class="mt-3 text-3xl font-bold text-stone-900">{{ number_format($stats['film_biodegradable_m2_this_month'] ?? 0, 2, ',', ' ') }} m2</p>
            <p class="mt-2 text-sm text-stone-500">production du mois</p>
        </div>
        <div class="stat-tile">
            <p class="text-sm text-stone-500">Plastique evite</p>
            <p class="mt-3 text-3xl font-bold text-stone-900">{{ number_format($stats['plastic_avoided_kg'] ?? 0, 2, ',', ' ') }} kg</p>
            <p class="mt-2 text-sm text-stone-500">impact cumule</p>
        </div>
        <div class="stat-tile">
            <p class="text-sm text-stone-500">Livraisons en retard</p>
            <p class="mt-3 text-3xl font-bold {{ ($stats['late_deliveries_count'] ?? 0) > 0 ? 'text-amber-600' : 'text-stone-900' }}">{{ $stats['late_deliveries_count'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-stone-500">dossiers a traiter</p>
        </div>
        <div class="stat-tile">
            <p class="text-sm text-stone-500">Paiements suivis</p>
            <p class="mt-3 text-3xl font-bold text-stone-900">{{ ($stats['pending_orders'] ?? 0) + ($stats['late_deliveries_count'] ?? 0) }}</p>
            <p class="mt-2 text-sm text-stone-500">points de vigilance</p>
        </div>
        <div class="stat-tile">
            <p class="text-sm text-stone-500">Cadence hebdo</p>
            <p class="mt-3 text-3xl font-bold text-[var(--bio-green)]">{{ number_format(collect($stats['weekly_sales'] ?? [])->sum('total'), 0, ',', ' ') }}</p>
            <p class="mt-2 text-sm text-stone-500">FCFA sur 7 jours</p>
        </div>
    </div>

    <div class="section-card bg-[linear-gradient(180deg,#ffffff_0%,#f9faf7_100%)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Activite recente</p>
                <h3 class="mt-2 text-2xl font-bold text-stone-900">Ventes hebdomadaires</h3>
                <p class="text-sm text-stone-500">Evolution des 7 derniers jours pour garder un rythme visible.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach (($stats['weekly_sales'] ?? []) as $day)
                    <span class="kpi-chip">{{ $day['label'] }}: {{ number_format($day['total'], 0, ',', ' ') }}</span>
                @endforeach
            </div>
        </div>
        @php($max = collect($stats['weekly_sales'] ?? [])->max('total') ?: 1)
        <div class="mt-6 grid gap-4 md:grid-cols-7">
            @foreach (($stats['weekly_sales'] ?? []) as $day)
                <div class="rounded-[1.75rem] border border-white/70 bg-white/90 p-4 shadow-lg shadow-stone-200/40">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">{{ $day['label'] }}</p>
                    <div class="mt-4 flex h-36 items-end rounded-[1.35rem] bg-[linear-gradient(180deg,#f5f2e8_0%,#ffffff_100%)] p-2">
                        <div class="w-full rounded-[1rem] bg-[linear-gradient(180deg,#7ba05b_0%,#2c5f2d_100%)] shadow-lg shadow-emerald-900/20" style="height: {{ max(8, ($day['total'] / $max) * 100) }}%"></div>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-stone-700">{{ number_format($day['total'], 0, ',', ' ') }} FCFA</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
