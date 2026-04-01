<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Produit extends Model
{
    use HasFactory;

    public const CATALOG_SLUGS = [
        'petit-transparent',
        'moyen-souple',
        'grand-solide',
        'film-biodegradable',
    ];

    protected $fillable = [
        'nom',
        'slug',
        'format',
        'usage_ideal',
        'description',
        'prix_unitaire',
        'cout_revient',
        'stock_disponible',
        'recette',
        'notes_production',
        'sechage_heures_min',
        'sechage_heures_max',
        'proprietes',
    ];

    protected static function booted(): void
    {
        static::creating(function (Produit $produit) {
            if (blank($produit->slug) && filled($produit->nom)) {
                $produit->slug = Str::slug($produit->nom);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'prix_unitaire' => 'decimal:2',
            'cout_revient' => 'decimal:2',
            'recette' => 'array',
            'proprietes' => 'array',
        ];
    }

    protected function sechageLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sechage_heures_min && $this->sechage_heures_max
                ? $this->sechage_heures_min.' a '.$this->sechage_heures_max.' h'
                : null,
        );
    }

    protected function proprietesText(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->proprietes ?? [])->implode(', '),
        );
    }

    protected function badgeProperties(): Attribute
    {
        return Attribute::make(
            get: function () {
                $properties = collect($this->proprietes ?? [])
                    ->map(fn ($property) => Str::lower((string) $property));

                return collect([
                    'Transparent' => $properties->contains(fn (string $property) => str_contains($property, 'transparent')),
                    'Souple' => $properties->contains(fn (string $property) => str_contains($property, 'souple')),
                    'Resistant' => $properties->contains(fn (string $property) => str_contains($property, 'resistant') || str_contains($property, 'solide')),
                    'Ultra-fin' => $properties->contains(fn (string $property) => str_contains($property, 'ultra-fin')),
                ])->filter()->keys()->values()->all();
            },
        );
    }

    public function isOfficialCatalog(): bool
    {
        return in_array($this->slug, self::CATALOG_SLUGS, true);
    }

    protected function recetteLines(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->recette ?? [])
                ->map(fn (string $quantity, string $ingredient) => $ingredient.': '.$quantity)
                ->implode(PHP_EOL),
        );
    }

    protected function whatsappOrderUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => 'https://wa.me/'.config('biosachet.whatsapp').'?text='.
                rawurlencode('Bonjour, je souhaite commander '.$this->nom.' pour '.$this->usage_ideal.'.'),
        );
    }

    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
            ->withPivot(['quantite', 'prix_unitaire'])
            ->withTimestamps();
    }

    public function scopePublicCatalog($query)
    {
        return $query->whereIn('slug', self::CATALOG_SLUGS)->catalogOrder();
    }

    public function scopeCatalogOrder($query)
    {
        return $query
            ->orderByRaw("
                CASE slug
                    WHEN 'petit-transparent' THEN 1
                    WHEN 'moyen-souple' THEN 2
                    WHEN 'grand-solide' THEN 3
                    WHEN 'film-biodegradable' THEN 4
                    ELSE 99
                END
            ")
            ->orderBy('prix_unitaire');
    }

    public function stockMouvements(): HasMany
    {
        return $this->hasMany(StockMouvement::class);
    }
}
