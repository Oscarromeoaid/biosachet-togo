<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductionRequest;
use App\Http\Requests\UpdateProductionRequest;
use App\Models\Produit;
use App\Models\Production;
use App\Services\ActivityLogService;

class ProductionController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index()
    {
        return view('admin.productions.index', [
            'productions' => Production::query()->orderByDesc('date')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.productions.create', [
            'production' => new Production(),
            'produitsReference' => Produit::query()->publicCatalog()->get(),
        ]);
    }

    public function store(StoreProductionRequest $request)
    {
        $production = Production::query()->create($request->validated());
        $this->activityLog->log('productions', 'create', 'Production enregistree: '.$production->date->format('d/m/Y'), $production);

        return redirect()->route('admin.productions.index')->with('success', 'Production du jour enregistree.');
    }

    public function show(Production $production)
    {
        return redirect()->route('admin.productions.edit', $production);
    }

    public function edit(Production $production)
    {
        return view('admin.productions.edit', [
            'production' => $production,
            'produitsReference' => Produit::query()->publicCatalog()->get(),
        ]);
    }

    public function update(UpdateProductionRequest $request, Production $production)
    {
        $production->update($request->validated());
        $this->activityLog->log('productions', 'update', 'Production mise a jour: '.$production->date->format('d/m/Y'), $production);

        return redirect()->route('admin.productions.index')->with('success', 'Production mise a jour.');
    }

    public function destroy(Production $production)
    {
        $this->activityLog->log('productions', 'delete', 'Production supprimee: '.$production->date->format('d/m/Y'), $production);
        $production->delete();

        return redirect()->route('admin.productions.index')->with('success', 'Production supprimee.');
    }
}
