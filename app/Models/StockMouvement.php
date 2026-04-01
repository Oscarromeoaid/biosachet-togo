<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMouvement extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'commande_id',
        'type',
        'quantite',
        'stock_avant',
        'stock_apres',
        'note',
    ];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
