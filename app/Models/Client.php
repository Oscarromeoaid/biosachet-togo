<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    public const TYPES = ['commerce', 'restaurant', 'ong', 'grossiste', 'export', 'pharmacie'];

    protected $fillable = [
        'user_id',
        'nom',
        'telephone',
        'email',
        'type',
        'ville',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst((string) $this->type),
        );
    }
}
