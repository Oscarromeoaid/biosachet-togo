<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\StorePublicOrderRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Produit;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
    ) {
    }

    public function index(): View
    {
        return view('site.panier', [
            'cartItems' => $this->cart->content(),
            'cartTotal' => $this->cart->total(),
            'cartCount' => $this->cart->count(),
            'typesClient' => \App\Models\Client::TYPES,
        ]);
    }

    public function store(StoreCartItemRequest $request): RedirectResponse
    {
        $produit = Produit::query()->publicCatalog()->findOrFail($request->integer('produit_id'));
        $this->cart->add($produit, $request->integer('quantite'));

        return back()->with('success', "{$produit->nom} a ete ajoute au panier.");
    }

    public function update(UpdateCartItemRequest $request, Produit $produit): RedirectResponse
    {
        $this->cart->update($produit, $request->integer('quantite'));

        return back()->with('success', 'Le panier a ete mis a jour.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $this->cart->remove($produit);

        return back()->with('success', 'Le produit a ete retire du panier.');
    }

    public function checkout(StorePublicOrderRequest $request): RedirectResponse
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('site.panier')->withErrors([
                'panier' => 'Votre panier est vide. Ajoutez au moins un produit avant de commander.',
            ]);
        }

        return redirect()->away($this->buildWhatsappCheckoutUrl($request));
    }

    public function confirmation(): View|RedirectResponse
    {
        $confirmation = session('public_order_confirmation');

        if (! $confirmation) {
            return redirect()->route('site.panier');
        }

        return view('site.commande-confirmee', [
            'confirmation' => $confirmation,
        ]);
    }

    private function buildWhatsappCheckoutUrl(StorePublicOrderRequest $request): string
    {
        $cartItems = $this->cart->content();

        $lines = $cartItems->map(function (array $item) {
            return '- '.$item['produit']->nom.' x'.$item['quantite'].' : '.number_format($item['sous_total'], 0, ',', ' ').' FCFA';
        })->implode("\n");

        $message = trim(implode("\n", array_filter([
            'Bonjour, je souhaite passer commande via WhatsApp.',
            '',
            'Nom/structure : '.$request->string('nom')->toString(),
            'Telephone : '.$request->string('telephone')->toString(),
            'Type de client : '.$request->string('type')->toString(),
            'Ville : '.$request->string('ville')->toString(),
            $request->filled('email') ? 'Email : '.$request->string('email')->toString() : null,
            $request->filled('date_livraison') ? 'Date de livraison souhaitee : '.$request->string('date_livraison')->toString() : null,
            '',
            'Produits :',
            $lines,
            '',
            'Total estimatif : '.number_format($this->cart->total(), 0, ',', ' ').' FCFA',
            'Merci de me confirmer la disponibilite et la suite sur WhatsApp.',
        ])));

        return 'https://wa.me/'.config('biosachet.whatsapp').'?text='.rawurlencode($message);
    }
}
