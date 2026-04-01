<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockMatiereRequest;
use App\Http\Requests\UpdateStockMatiereRequest;
use App\Models\StockMatiere;
use App\Services\ActivityLogService;

class StockMatiereController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index()
    {
        return view('admin.stocks-matieres.index', [
            'stocks' => StockMatiere::query()->orderByDesc('date_achat')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.stocks-matieres.create', ['stock' => new StockMatiere()]);
    }

    public function store(StoreStockMatiereRequest $request)
    {
        $stock = StockMatiere::query()->create($request->validated());
        $this->activityLog->log('stocks', 'create', 'Entree de stock matiere enregistree: '.$stock->fournisseur, $stock);

        return redirect()->route('admin.stocks-matieres.index')->with('success', 'Achat de matiere enregistre.');
    }

    public function show(StockMatiere $stockMatiere)
    {
        return redirect()->route('admin.stocks-matieres.edit', $stockMatiere);
    }

    public function edit(StockMatiere $stockMatiere)
    {
        return view('admin.stocks-matieres.edit', ['stock' => $stockMatiere]);
    }

    public function update(UpdateStockMatiereRequest $request, StockMatiere $stockMatiere)
    {
        $stockMatiere->update($request->validated());
        $this->activityLog->log('stocks', 'update', 'Entree de stock mise a jour: '.$stockMatiere->fournisseur, $stockMatiere);

        return redirect()->route('admin.stocks-matieres.index')->with('success', 'Achat mis a jour.');
    }

    public function destroy(StockMatiere $stockMatiere)
    {
        $this->activityLog->log('stocks', 'delete', 'Entree de stock supprimee: '.$stockMatiere->fournisseur, $stockMatiere);
        $stockMatiere->delete();

        return redirect()->route('admin.stocks-matieres.index')->with('success', 'Entree de stock supprimee.');
    }
}
