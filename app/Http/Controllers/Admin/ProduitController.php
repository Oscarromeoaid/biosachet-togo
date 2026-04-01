<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Produit;
use App\Services\ActivityLogService;

class ProduitController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index()
    {
        $catalogCount = Produit::query()->publicCatalog()->count();

        return view('admin.produits.index', [
            'produits' => Produit::query()->publicCatalog()->paginate(15),
            'canCreateProduit' => $catalogCount < count(Produit::CATALOG_SLUGS),
        ]);
    }

    public function create()
    {
        if (Produit::query()->publicCatalog()->count() >= count(Produit::CATALOG_SLUGS)) {
            return redirect()
                ->route('admin.produits.index')
                ->withErrors(['produits' => 'Le catalogue est deja complet avec les 4 types officiels.']);
        }

        return view('admin.produits.create', ['produit' => new Produit()]);
    }

    public function store(StoreProduitRequest $request)
    {
        if (Produit::query()->publicCatalog()->count() >= count(Produit::CATALOG_SLUGS)) {
            return redirect()
                ->route('admin.produits.index')
                ->withErrors(['produits' => 'Le catalogue est deja complet avec les 4 types officiels.']);
        }

        $produit = Produit::query()->create($request->validated());
        $this->activityLog->log('produits', 'create', 'Produit ajoute: '.$produit->nom, $produit);

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajoute avec succes.');
    }

    public function show(Produit $produit)
    {
        return redirect()->route('admin.produits.edit', $produit);
    }

    public function edit(Produit $produit)
    {
        return view('admin.produits.edit', [
            'produit' => $produit,
            'identityLocked' => $produit->isOfficialCatalog(),
        ]);
    }

    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        $data = $request->validated();

        if ($produit->isOfficialCatalog()) {
            $data = collect($data)
                ->except(['nom', 'slug', 'format'])
                ->all();
        }

        $produit->update($data);
        $this->activityLog->log('produits', 'update', 'Produit mis a jour: '.$produit->nom, $produit);

        return redirect()->route('admin.produits.index')->with('success', 'Produit mis a jour.');
    }

    public function destroy(Produit $produit)
    {
        if (in_array($produit->slug, Produit::CATALOG_SLUGS, true)) {
            return redirect()
                ->route('admin.produits.index')
                ->withErrors(['produits' => 'Les 4 types officiels ne peuvent pas etre supprimes depuis l admin.']);
        }

        $this->activityLog->log('produits', 'delete', 'Produit supprime: '.$produit->nom, $produit);
        $produit->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprime.');
    }
}
