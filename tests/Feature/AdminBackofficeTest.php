<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Production;
use App\Models\Produit;
use App\Models\User;
use App\Services\CommandeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBackofficeTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_access_admin_accounts_screen(): void
    {
        $user = User::factory()->admin()->create([
            'admin_role' => User::ADMIN_ROLE_SUPER_ADMIN,
        ]);

        $this->actingAs($user)
            ->get(route('admin.admin-users.index'))
            ->assertOk();
    }

    public function test_operations_admin_cannot_access_admin_accounts_screen(): void
    {
        $user = User::factory()->admin()->create([
            'admin_role' => User::ADMIN_ROLE_OPERATIONS,
        ]);

        $this->actingAs($user)
            ->get(route('admin.admin-users.index'))
            ->assertForbidden();
    }

    public function test_finance_admin_can_record_payment_and_update_payment_status(): void
    {
        $finance = User::factory()->admin()->create([
            'admin_role' => User::ADMIN_ROLE_FINANCE,
        ]);

        $client = Client::factory()->create();
        $produit = Produit::factory()->create([
            'nom' => 'GRAND SACHET EPAIS ET SOLIDE',
            'slug' => 'grand-solide',
            'format' => 'Large',
            'usage_ideal' => 'shopping bag, transport de courses (2 a 4 kg)',
            'prix_unitaire' => 50,
        ]);

        /** @var CommandeService $service */
        $service = app(CommandeService::class);

        $commande = $service->store([
            'client_id' => $client->id,
            'statut' => 'confirmee',
            'paiement' => 'en_attente',
            'methode_paiement' => 'flooz',
            'date_livraison' => now()->addDay()->toDateString(),
            'produits' => [
                [
                    'produit_id' => $produit->id,
                    'quantite' => 4,
                    'prix_unitaire' => 50,
                ],
            ],
        ]);

        $this->actingAs($finance)
            ->post(route('admin.commandes.paiements.store', $commande), [
                'montant' => 120,
                'methode_paiement' => 'flooz',
                'reference_paiement' => 'FLOOZ-001',
                'date_paiement' => now()->toDateString(),
                'note' => 'Acompte client',
            ])
            ->assertRedirect(route('admin.commandes.show', $commande));

        $commande->refresh();

        $this->assertSame('partiel', $commande->paiement);
        $this->assertDatabaseHas('commande_paiements', [
            'commande_id' => $commande->id,
            'reference_paiement' => 'FLOOZ-001',
        ]);
    }

    public function test_non_admin_user_cannot_authenticate_on_admin_login(): void
    {
        $client = User::factory()->create([
            'role' => User::ROLE_CLIENT,
            'admin_role' => null,
        ]);

        $this->post(route('login'), [
            'email' => $client->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_finance_admin_can_download_production_type_exports(): void
    {
        $finance = User::factory()->admin()->create([
            'admin_role' => User::ADMIN_ROLE_FINANCE,
        ]);

        Production::factory()->count(3)->create();

        $this->actingAs($finance)
            ->get(route('admin.rapports.production-types.excel'))
            ->assertOk()
            ->assertHeader('content-disposition', 'attachment; filename=rapport-production-types.xlsx');

        $this->actingAs($finance)
            ->get(route('admin.rapports.production-types.csv'))
            ->assertOk()
            ->assertHeader('content-disposition', 'attachment; filename=rapport-production-types.csv');
    }
}
