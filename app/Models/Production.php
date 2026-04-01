<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'kg_manioc_utilise',
        'sachets_petit_transparent',
        'sachets_moyen_souple',
        'sachets_grand_solide',
        'film_biodegradable_m2',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'kg_manioc_utilise' => 'decimal:2',
            'film_biodegradable_m2' => 'decimal:2',
        ];
    }

    protected function totalSachets(): Attribute
    {
        return Attribute::make(
            get: fn () => (int) $this->sachets_petit_transparent
                + (int) $this->sachets_moyen_souple
                + (int) $this->sachets_grand_solide,
        );
    }

    protected function plastiqueEviteKg(): Attribute
    {
        return Attribute::make(
            get: fn () => round(($this->total_sachets * 12) / 1000, 2),
        );
    }

    protected function resumeProduction(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'petit_transparent' => (int) $this->sachets_petit_transparent,
                'moyen_souple' => (int) $this->sachets_moyen_souple,
                'grand_solide' => (int) $this->sachets_grand_solide,
                'film_biodegradable_m2' => (float) $this->film_biodegradable_m2,
            ],
        );
    }
}
