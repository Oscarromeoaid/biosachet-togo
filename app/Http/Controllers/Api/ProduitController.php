<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProduitResource;
use App\Models\Produit;

class ProduitController extends Controller
{
    public function index()
    {
        return ProduitResource::collection(Produit::query()->publicCatalog()->get());
    }

    public function show(Produit $produit)
    {
        return new ProduitResource($produit);
    }
}
