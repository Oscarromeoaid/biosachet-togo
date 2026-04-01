<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Produit;

class AlertService
{
    public function all(): array
    {
        $lowStockProducts = Produit::query()
            ->publicCatalog()
            ->where('stock_disponible', '<', 120)
            ->take(10)
            ->get();

        $overdueOrders = Commande::query()
            ->with('client')
            ->whereIn('statut', ['en_attente', 'confirmee'])
            ->whereDate('date_livraison', '<', now()->toDateString())
            ->orderBy('date_livraison')
            ->take(10)
            ->get();

        $unpaidOrders = Commande::query()
            ->with('client')
            ->whereIn('statut', ['confirmee', 'livree'])
            ->where('paiement', '!=', 'paye')
            ->whereDate('created_at', '<=', now()->subDays(7)->toDateString())
            ->latest()
            ->take(10)
            ->get();

        $cassavaAlert = app(DashboardMetricsService::class)->get()['cassava_alert'] ?? false;

        return [
            'low_stock_products' => $lowStockProducts,
            'overdue_orders' => $overdueOrders,
            'unpaid_orders' => $unpaidOrders,
            'cassava_alert' => $cassavaAlert,
            'count' => $lowStockProducts->count() + $overdueOrders->count() + $unpaidOrders->count() + ($cassavaAlert ? 1 : 0),
        ];
    }
}
