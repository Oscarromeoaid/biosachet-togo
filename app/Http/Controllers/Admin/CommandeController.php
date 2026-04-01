<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use App\Services\CommandeService;
use Illuminate\Http\Request;
use RuntimeException;

class CommandeController extends Controller
{
    public function __construct(private readonly CommandeService $commandeService)
    {
    }

    public function index(Request $request)
    {
        $query = Commande::query()->with(['client', 'produits'])->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->string('statut'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->integer('client_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date('date'));
        }

        return view('admin.commandes.index', [
            'commandes' => $query->paginate(15)->withQueryString(),
            'clients' => Client::query()->orderBy('nom')->get(),
            'statuts' => Commande::STATUTS,
        ]);
    }

    public function create()
    {
        return view('admin.commandes.create', [
            'commande' => new Commande(),
            'clients' => Client::query()->orderBy('nom')->get(),
            'produits' => Produit::query()->publicCatalog()->get(),
        ]);
    }

    public function store(StoreCommandeRequest $request)
    {
        try {
            $this->commandeService->store($request->validated());
        } catch (RuntimeException $exception) {
            return back()->withInput()->withErrors(['commande' => $exception->getMessage()]);
        }

        return redirect()->route('admin.commandes.index')->with('success', 'Commande enregistree avec succes.');
    }

    public function show(Commande $commande)
    {
        return view('admin.commandes.show', [
            'commande' => $commande->load(['client', 'produits', 'paiements.creator']),
        ]);
    }

    public function edit(Commande $commande)
    {
        return view('admin.commandes.edit', [
            'commande' => $commande->load('produits'),
            'clients' => Client::query()->orderBy('nom')->get(),
            'produits' => Produit::query()->publicCatalog()->get(),
        ]);
    }

    public function update(UpdateCommandeRequest $request, Commande $commande)
    {
        try {
            $this->commandeService->update($commande, $request->validated());
        } catch (RuntimeException $exception) {
            return back()->withInput()->withErrors(['commande' => $exception->getMessage()]);
        }

        return redirect()->route('admin.commandes.index')->with('success', 'Commande mise a jour.');
    }

    public function destroy(Commande $commande)
    {
        try {
            $this->commandeService->destroy($commande);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['commande' => $exception->getMessage()]);
        }

        return redirect()->route('admin.commandes.index')->with('success', 'Commande supprimee.');
    }
}
