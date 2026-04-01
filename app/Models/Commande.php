<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    use HasFactory;

    public const STATUTS = ['en_attente', 'confirmee', 'livree', 'annulee'];

    public const PAIEMENTS = ['paye', 'en_attente', 'partiel'];

    public const METHODES_PAIEMENT = ['cash', 'flooz', 't_money'];

    protected $fillable = [
        'reference',
        'suivi_token',
        'client_id',
        'total',
        'statut',
        'paiement',
        'methode_paiement',
        'date_livraison',
        'stock_decremente_le',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'date_livraison' => 'date',
            'stock_decremente_le' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
            ->withPivot(['quantite', 'prix_unitaire'])
            ->withTimestamps();
    }

    public function stockMouvements(): HasMany
    {
        return $this->hasMany(StockMouvement::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(CommandePaiement::class);
    }

    protected function statutLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->statut) {
                'en_attente' => 'En attente',
                'confirmee' => 'Confirmee',
                'livree' => 'Livree',
                'annulee' => 'Annulee',
                default => ucfirst((string) $this->statut),
            },
        );
    }

    protected function paiementLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->paiement) {
                'en_attente' => 'En attente',
                'partiel' => 'Partiel',
                'paye' => 'Paye',
                default => ucfirst((string) $this->paiement),
            },
        );
    }

    protected function methodePaiementLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => config('biosachet.payment_methods')[$this->methode_paiement] ?? $this->methode_paiement,
        );
    }

    protected function totalPaye(): Attribute
    {
        return Attribute::make(
            get: fn () => round((float) ($this->relationLoaded('paiements') ? $this->paiements->sum('montant') : $this->paiements()->sum('montant')), 2),
        );
    }

    protected function soldeRestant(): Attribute
    {
        return Attribute::make(
            get: fn () => round(max(0, (float) $this->total - (float) $this->total_paye), 2),
        );
    }
}
