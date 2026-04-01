<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommandePaiementRequest;
use App\Models\Commande;
use App\Models\CommandePaiement;
use App\Services\CommandePaiementService;
use RuntimeException;

class CommandePaiementController extends Controller
{
    public function __construct(private readonly CommandePaiementService $paiementService)
    {
    }

    public function store(StoreCommandePaiementRequest $request, Commande $commande)
    {
        try {
            $this->paiementService->store($commande, $request->validated());
        } catch (RuntimeException $exception) {
            return back()->withErrors(['paiement' => $exception->getMessage()])->withInput();
        }

        return redirect()->route('admin.commandes.show', $commande)->with('success', 'Paiement enregistre.');
    }

    public function destroy(Commande $commande, CommandePaiement $paiement)
    {
        abort_unless($paiement->commande_id === $commande->id, 404);

        try {
            $this->paiementService->destroy($paiement);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['paiement' => $exception->getMessage()]);
        }

        return redirect()->route('admin.commandes.show', $commande)->with('success', 'Paiement supprime.');
    }
}
