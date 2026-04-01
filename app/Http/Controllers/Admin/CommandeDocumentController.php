<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeDocumentController extends Controller
{
    public function quote(Commande $commande)
    {
        return Pdf::loadView('pdf.commande-quote', [
            'commande' => $commande->load(['client', 'produits']),
        ])->download('devis-'.$commande->reference.'.pdf');
    }
}
