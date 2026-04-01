<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicOrderTrackingController extends Controller
{
    public function index(): View
    {
        return view('site.suivi-commande', [
            'commande' => null,
        ]);
    }

    public function lookup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reference' => ['required', 'string'],
            'telephone' => ['required', 'digits:8'],
        ]);

        $commande = Commande::query()
            ->with(['client', 'produits'])
            ->where('reference', $validated['reference'])
            ->whereHas('client', fn ($query) => $query->where('telephone', $validated['telephone']))
            ->first();

        if (! $commande) {
            return back()->withErrors([
                'suivi' => 'Aucune commande ne correspond a cette reference et a ce numero.',
            ])->withInput();
        }

        return redirect()->route('site.commande.suivi.show', $commande->suivi_token);
    }

    public function show(string $token): View
    {
        $commande = Commande::query()
            ->with(['client', 'produits'])
            ->where('suivi_token', $token)
            ->firstOrFail();

        return view('site.suivi-commande', [
            'commande' => $commande,
        ]);
    }

    public function quote(string $token)
    {
        $commande = Commande::query()
            ->with(['client', 'produits'])
            ->where('suivi_token', $token)
            ->firstOrFail();

        return Pdf::loadView('pdf.commande-quote', [
            'commande' => $commande,
        ])->download('devis-'.$commande->reference.'.pdf');
    }
}
