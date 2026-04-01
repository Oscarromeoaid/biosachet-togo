<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_CLIENT = 'client';

    public const ADMIN_ROLE_SUPER_ADMIN = 'super_admin';

    public const ADMIN_ROLE_OPERATIONS = 'operations';

    public const ADMIN_ROLE_FINANCE = 'finance';

    public const ADMIN_ROLE_STOCK = 'stock';

    public const ADMIN_ROLES = [
        self::ADMIN_ROLE_SUPER_ADMIN,
        self::ADMIN_ROLE_OPERATIONS,
        self::ADMIN_ROLE_FINANCE,
        self::ADMIN_ROLE_STOCK,
    ];

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'role',
        'admin_role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function recordedPayments(): HasMany
    {
        return $this->hasMany(CommandePaiement::class, 'created_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function hasAdminRole(string $role): bool
    {
        return $this->isAdmin() && $this->admin_role === $role;
    }

    public function hasAnyAdminRole(array $roles): bool
    {
        return $this->isAdmin() && in_array($this->admin_role, $roles, true);
    }

    public function canAccessAdminSection(string $section): bool
    {
        if (! $this->isAdmin()) {
            return false;
        }

        $permissions = [
            'dashboard' => self::ADMIN_ROLES,
            'produits' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_OPERATIONS],
            'clients' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_OPERATIONS],
            'commandes' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_OPERATIONS, self::ADMIN_ROLE_FINANCE],
            'productions' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_OPERATIONS, self::ADMIN_ROLE_STOCK],
            'stocks' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_OPERATIONS, self::ADMIN_ROLE_STOCK],
            'rapports' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_FINANCE],
            'paiements' => [self::ADMIN_ROLE_SUPER_ADMIN, self::ADMIN_ROLE_FINANCE],
            'alertes' => self::ADMIN_ROLES,
            'activites' => [self::ADMIN_ROLE_SUPER_ADMIN],
            'admins' => [self::ADMIN_ROLE_SUPER_ADMIN],
        ];

        return in_array($this->admin_role, $permissions[$section] ?? [], true);
    }

    public function getAdminRoleLabelAttribute(): string
    {
        return match ($this->admin_role) {
            self::ADMIN_ROLE_SUPER_ADMIN => 'Super admin',
            self::ADMIN_ROLE_OPERATIONS => 'Operations',
            self::ADMIN_ROLE_FINANCE => 'Finance',
            self::ADMIN_ROLE_STOCK => 'Stock',
            default => 'Admin',
        };
    }
}
