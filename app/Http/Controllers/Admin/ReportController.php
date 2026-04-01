<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EnvironmentalImpactExport;
use App\Exports\FinancialSummaryExport;
use App\Exports\ProductionTypesExport;
use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Production;
use App\Models\StockMatiere;
use App\Services\DashboardMetricsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $metrics)
    {
    }

    public function index()
    {
        $impact = $this->metrics->get();
        $financial = $this->metrics->financialSummary();

        return view('admin.rapports.index', [
            'impact' => $impact,
            'financial' => $financial,
        ]);
    }

    public function environmentalPdf()
    {
        $impact = $this->metrics->get();

        return Pdf::loadView('pdf.environmental-impact', [
            'impact' => $impact,
            'productions' => Production::query()->orderByDesc('date')->take(30)->get(),
        ])->download('rapport-impact-environnemental.pdf');
    }

    public function financialPdf()
    {
        $financial = $this->metrics->financialSummary();

        return Pdf::loadView('pdf.financial-summary', [
            'financial' => $financial,
            'commandes' => Commande::query()->with('client')->latest()->take(20)->get(),
            'stocks' => StockMatiere::query()->latest('date_achat')->take(20)->get(),
        ])->download('rapport-financier.pdf');
    }

    public function environmentalExcel()
    {
        return Excel::download(
            new EnvironmentalImpactExport(
                $this->metrics->get(),
                Production::query()->orderByDesc('date')->take(30)->get()
            ),
            'rapport-impact-environnemental.xlsx'
        );
    }

    public function financialExcel()
    {
        return Excel::download(
            new FinancialSummaryExport(
                $this->metrics->financialSummary(),
                Commande::query()->with('client')->latest()->take(20)->get(),
                StockMatiere::query()->latest('date_achat')->take(20)->get()
            ),
            'rapport-financier.xlsx'
        );
    }

    public function productionTypesExcel()
    {
        return Excel::download(
            new ProductionTypesExport(
                Production::query()->orderByDesc('date')->take(30)->get()
            ),
            'rapport-production-types.xlsx'
        );
    }

    public function productionTypesCsv()
    {
        return Excel::download(
            new ProductionTypesExport(
                Production::query()->orderByDesc('date')->take(30)->get()
            ),
            'rapport-production-types.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
