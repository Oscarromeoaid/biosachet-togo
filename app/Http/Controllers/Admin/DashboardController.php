<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Services\DashboardMetricsService;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $metrics)
    {
    }

    public function index()
    {
        return view('admin.dashboard.index', [
            'recentCommandes' => Commande::query()->with('client')->latest()->take(5)->get(),
            'lowStockProduits' => Produit::query()->publicCatalog()->where('stock_disponible', '<', 50)->get(),
            'insights' => $this->metrics->dashboardInsights(),
        ]);
    }
}
