<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Production;
use App\Models\StockMatiere;
use App\Models\StockMouvement;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class DashboardMetricsService
{
    public function __construct(private readonly ProduitAvailabilityService $availability)
    {
    }

    public function get(): array
    {
        $now = CarbonImmutable::now();
        $startOfMonth = $now->startOfMonth();
        $lastWeek = collect(range(6, 0))->map(fn (int $offset) => $now->subDays($offset));

        $monthlyRevenue = (float) Commande::query()
            ->where('statut', '!=', 'annulee')
            ->where('paiement', '!=', 'en_attente')
            ->whereBetween('created_at', [$startOfMonth, $now->endOfDay()])
            ->sum('total');

        $pendingOrders = Commande::query()->where('statut', 'en_attente')->count();

        $sachetsProducedThisMonth = (int) Production::query()
            ->whereBetween('date', [$startOfMonth->toDateString(), $now->toDateString()])
            ->get()
            ->sum(fn (Production $production) => $production->total_sachets);

        $plasticAvoidedKg = $this->plasticAvoidedKg();
        $cassavaStockKg = $this->cassavaStockKg();
        $filmBiodegradableThisMonth = (float) Production::query()
            ->whereBetween('date', [$startOfMonth->toDateString(), $now->toDateString()])
            ->sum('film_biodegradable_m2');

        $weeklySales = $lastWeek->map(function (CarbonImmutable $day) {
            $total = (float) Commande::query()
                ->whereDate('created_at', $day->toDateString())
                ->where('statut', '!=', 'annulee')
                ->sum('total');

            return [
                'label' => $day->locale('fr')->isoFormat('ddd'),
                'date' => $day->toDateString(),
                'total' => round($total, 2),
            ];
        })->values();

        return [
            'monthly_revenue' => round($monthlyRevenue, 2),
            'pending_orders' => $pendingOrders,
            'sachets_produced_this_month' => $sachetsProducedThisMonth,
            'film_biodegradable_m2_this_month' => round($filmBiodegradableThisMonth, 2),
            'plastic_avoided_kg' => $plasticAvoidedKg,
            'cassava_stock_kg' => $cassavaStockKg,
            'weekly_sales' => $weeklySales,
            'cassava_alert' => $cassavaStockKg < 50,
            'jobs_created' => config('biosachet.jobs_created'),
            'partner_schools' => config('biosachet.partner_schools'),
            'clients_served' => Client::query()->count(),
            'late_deliveries_count' => $this->lateDeliveries()->count(),
        ];
    }

    public function dashboardInsights(): array
    {
        return [
            'top_products' => $this->topProducts(),
            'top_clients' => $this->topClients(),
            'payment_breakdown' => $this->paymentBreakdown(),
            'late_deliveries' => $this->lateDeliveries(),
            'stock_pressure' => $this->stockPressure(),
            'recent_stock_movements' => $this->recentStockMovements(),
        ];
    }

    public function plasticAvoidedKg(): float
    {
        $totalSachets = (int) Production::query()
            ->selectRaw('SUM(sachets_petit_transparent + sachets_moyen_souple + sachets_grand_solide) as total')
            ->value('total');

        return round(($totalSachets * 12) / 1000, 2);
    }

    public function cassavaStockKg(): float
    {
        $purchased = (float) StockMatiere::query()->sum('quantite_kg');
        $used = (float) Production::query()->sum('kg_manioc_utilise');

        return round($purchased - $used, 2);
    }

    public function financialSummary(): array
    {
        $revenue = (float) Commande::query()
            ->where('statut', '!=', 'annulee')
            ->sum('total');

        $rawMaterialCosts = (float) StockMatiere::query()->sum('cout_total');
        $estimatedUnitCosts = (float) DB::table('commande_produit')
            ->sum(DB::raw('quantite * '.(float) config('biosachet.default_cost_per_sachet')));

        $netProfit = $revenue - $rawMaterialCosts - $estimatedUnitCosts;

        return [
            'revenue' => round($revenue, 2),
            'costs' => round($rawMaterialCosts + $estimatedUnitCosts, 2),
            'raw_material_costs' => round($rawMaterialCosts, 2),
            'estimated_unit_costs' => round($estimatedUnitCosts, 2),
            'net_profit' => round($netProfit, 2),
        ];
    }

    protected function topProducts()
    {
        $startOfMonth = now()->startOfMonth();

        return DB::table('commande_produit')
            ->join('commandes', 'commandes.id', '=', 'commande_produit.commande_id')
            ->join('produits', 'produits.id', '=', 'commande_produit.produit_id')
            ->where('commandes.statut', '!=', 'annulee')
            ->whereBetween('commandes.created_at', [$startOfMonth, now()->endOfDay()])
            ->selectRaw('produits.nom, produits.format, SUM(commande_produit.quantite) as quantite_totale, SUM(commande_produit.quantite * commande_produit.prix_unitaire) as chiffre_affaires')
            ->groupBy('produits.id', 'produits.nom', 'produits.format')
            ->orderByDesc('quantite_totale')
            ->limit(5)
            ->get();
    }

    protected function topClients()
    {
        $startOfMonth = now()->startOfMonth();

        return Commande::query()
            ->join('clients', 'clients.id', '=', 'commandes.client_id')
            ->where('commandes.statut', '!=', 'annulee')
            ->whereBetween('commandes.created_at', [$startOfMonth, now()->endOfDay()])
            ->selectRaw('clients.nom, clients.type, COUNT(commandes.id) as commandes_count, SUM(commandes.total) as revenu_total')
            ->groupBy('clients.id', 'clients.nom', 'clients.type')
            ->orderByDesc('revenu_total')
            ->limit(5)
            ->get();
    }

    protected function paymentBreakdown()
    {
        $startOfMonth = now()->startOfMonth();

        return Commande::query()
            ->where('statut', '!=', 'annulee')
            ->whereBetween('created_at', [$startOfMonth, now()->endOfDay()])
            ->selectRaw('methode_paiement, COUNT(*) as total_commandes, SUM(total) as total_ca')
            ->groupBy('methode_paiement')
            ->get()
            ->map(fn ($row) => [
                'label' => config('biosachet.payment_methods')[$row->methode_paiement] ?? $row->methode_paiement,
                'total_commandes' => (int) $row->total_commandes,
                'total_ca' => (float) $row->total_ca,
            ]);
    }

    protected function lateDeliveries()
    {
        return Commande::query()
            ->with('client')
            ->whereIn('statut', ['en_attente', 'confirmee'])
            ->whereDate('date_livraison', '<', now()->toDateString())
            ->orderBy('date_livraison')
            ->limit(6)
            ->get();
    }

    protected function stockPressure()
    {
        return \App\Models\Produit::query()
            ->publicCatalog()
            ->get()
            ->map(function ($produit) {
                $reserve = $this->availability->reservedQuantity($produit);
                $disponibleCommande = $this->availability->availableToOrder($produit);

                return [
                    'nom' => $produit->nom,
                    'format' => $produit->format,
                    'stock_disponible' => (int) $produit->stock_disponible,
                    'reserve' => $reserve,
                    'disponible_commande' => $disponibleCommande,
                ];
            })
            ->filter(fn (array $item) => $item['reserve'] > 0 || $item['disponible_commande'] < 120)
            ->sortBy('disponible_commande')
            ->take(6)
            ->values();
    }

    protected function recentStockMovements()
    {
        return StockMouvement::query()
            ->with(['produit', 'commande'])
            ->latest()
            ->limit(8)
            ->get();
    }
}
