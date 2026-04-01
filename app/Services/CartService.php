<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;

class CartService
{
    public const SESSION_KEY = 'site_cart';

    public function __construct(private readonly SessionManager $session)
    {
    }

    public function content(): Collection
    {
        $cart = collect($this->session->get(self::SESSION_KEY, []));

        if ($cart->isEmpty()) {
            return collect();
        }

        $produits = Produit::query()
            ->whereIn('id', $cart->keys())
            ->get()
            ->keyBy('id');

        return $cart->map(function (int $quantite, int|string $produitId) use ($produits) {
            $produit = $produits->get((int) $produitId);

            if (! $produit) {
                return null;
            }

            $sousTotal = $quantite * (float) $produit->prix_unitaire;

            return [
                'produit' => $produit,
                'quantite' => $quantite,
                'sous_total' => round($sousTotal, 2),
            ];
        })->filter()->values();
    }

    public function add(Produit $produit, int $quantite = 1): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);
        $current = (int) ($cart[$produit->id] ?? 0);
        $cart[$produit->id] = $current + max(1, $quantite);

        $this->session->put(self::SESSION_KEY, $cart);
    }

    public function update(Produit $produit, int $quantite): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);

        if ($quantite <= 0) {
            unset($cart[$produit->id]);
        } else {
            $cart[$produit->id] = $quantite;
        }

        $this->session->put(self::SESSION_KEY, $cart);
    }

    public function remove(Produit $produit): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);
        unset($cart[$produit->id]);

        $this->session->put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return (int) collect($this->session->get(self::SESSION_KEY, []))->sum();
    }

    public function total(): float
    {
        return round((float) $this->content()->sum('sous_total'), 2);
    }

    public function toOrderLines(): array
    {
        return $this->content()->map(fn (array $item) => [
            'produit_id' => $item['produit']->id,
            'quantite' => $item['quantite'],
            'prix_unitaire' => (float) $item['produit']->prix_unitaire,
        ])->all();
    }
}
