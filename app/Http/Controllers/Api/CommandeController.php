<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreApiCommandeRequest;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
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
        $client = $request->user()?->client;
        abort_unless($client, 403, 'Compte client requis.');

        return CommandeResource::collection(
            Commande::query()
                ->with(['client', 'produits'])
                ->where('client_id', $client->id)
                ->latest()
                ->get()
        );
    }

    public function store(StoreApiCommandeRequest $request)
    {
        $client = $request->user()?->client;
        abort_unless($client, 403, 'Compte client requis.');

        $validated = $request->validated();
        $validated['client_id'] = $client->id;
        $validated['statut'] = 'en_attente';
        $validated['paiement'] = 'en_attente';

        try {
            $commande = $this->commandeService->store($validated);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }

        return (new CommandeResource($commande))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Commande $commande)
    {
        $client = $request->user()?->client;
        abort_unless($client && $commande->client_id === $client->id, 404);

        return new CommandeResource($commande->load(['client', 'produits']));
    }
}
