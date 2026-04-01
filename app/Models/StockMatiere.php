<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMatiere extends Model
{
    use HasFactory;

    protected $table = 'stock_matieres';

    protected $fillable = [
        'date_achat',
        'quantite_kg',
        'cout_total',
        'fournisseur',
    ];

    protected function casts(): array
    {
        return [
            'date_achat' => 'date',
            'quantite_kg' => 'decimal:2',
            'cout_total' => 'decimal:2',
        ];
    }
}
