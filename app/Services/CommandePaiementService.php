<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\CommandePaiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CommandePaiementService
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function store(Commande $commande, array $validated): CommandePaiement
    {
        return DB::transaction(function () use ($commande, $validated) {
            if ((float) $validated['montant'] > (float) $commande->solde_restant) {
                throw new RuntimeException('Le montant depasse le solde restant de la commande.');
            }

            $paiement = $commande->paiements()->create([
                'created_by' => Auth::id(),
                'montant' => $validated['montant'],
                'methode_paiement' => $validated['methode_paiement'],
                'reference_paiement' => $validated['reference_paiement'] ?? null,
                'date_paiement' => $validated['date_paiement'],
                'note' => $validated['note'] ?? null,
            ]);

            $this->syncPaymentStatus($commande->refresh());

            $this->activityLog->log(
                'paiements',
                'create',
                'Paiement enregistre sur la commande '.$commande->reference,
                $paiement,
                [
                    'commande_id' => $commande->id,
                    'montant' => (float) $paiement->montant,
                    'methode_paiement' => $paiement->methode_paiement,
                ]
            );

            return $paiement;
        });
    }

    public function destroy(CommandePaiement $paiement): void
    {
        DB::transaction(function () use ($paiement) {
            $commande = $paiement->commande;
            $this->activityLog->log(
                'paiements',
                'delete',
                'Paiement supprime sur la commande '.$commande->reference,
                $paiement,
                [
                    'commande_id' => $commande->id,
                    'montant' => (float) $paiement->montant,
                ]
            );
            $paiement->delete();
            $this->syncPaymentStatus($commande->refresh());
        });
    }

    protected function syncPaymentStatus(Commande $commande): void
    {
        $paid = (float) $commande->paiements()->sum('montant');
        $total = (float) $commande->total;

        $status = match (true) {
            $paid <= 0 => 'en_attente',
            $paid >= $total => 'paye',
            default => 'partiel',
        };

        $commande->forceFill(['paiement' => $status])->save();
    }
}
