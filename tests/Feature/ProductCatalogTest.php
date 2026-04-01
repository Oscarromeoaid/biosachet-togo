<?php

namespace Tests\Feature;

use App\Models\Produit;
use App\Models\User;
use Database\Seeders\ProduitSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_products_page_only_displays_the_official_catalog(): void
    {
        $this->seed(ProduitSeeder::class);

        Produit::factory()->create([
            'nom' => 'Ancien Produit Cache',
            'slug' => 'ancien-produit-cache',
            'format' => 'Legacy',
            'usage_ideal' => 'test interne',
        ]);

        $response = $this->get(route('site.produits'));

        $response->assertOk();
        $response->assertSee('PETIT SACHET TRANSPARENT');
        $response->assertSee('SACHET MOYEN SOUPLE');
        $response->assertSee('GRAND SACHET EPAIS ET SOLIDE');
        $response->assertSee('FILM PLASTIQUE BIODEGRADABLE');
        $response->assertDontSee('Ancien Produit Cache');
    }

    public function test_operations_admin_cannot_open_product_creation_when_catalog_is_complete(): void
    {
        $this->seed(ProduitSeeder::class);

        $user = User::factory()->admin()->create([
            'admin_role' => User::ADMIN_ROLE_OPERATIONS,
        ]);

        $this->actingAs($user)
            ->get(route('admin.produits.create'))
            ->assertRedirect(route('admin.produits.index'))
            ->assertSessionHasErrors('produits');
    }

    public function test_operations_admin_cannot_delete_an_official_catalog_product(): void
    {
        $this->seed(ProduitSeeder::class);

        $user = User::factory()->admin()->create([
            'admin_role' => User::ADMIN_ROLE_OPERATIONS,
        ]);

        $produit = Produit::query()->where('slug', 'petit-transparent')->firstOrFail();

        $this->actingAs($user)
            ->delete(route('admin.produits.destroy', $produit))
            ->assertRedirect(route('admin.produits.index'))
            ->assertSessionHasErrors('produits');

        $this->assertDatabaseHas('produits', ['id' => $produit->id]);
    }

    public function test_cart_rejects_non_catalog_products(): void
    {
        $produit = Produit::factory()->create([
            'nom' => 'Produit Hors Catalogue',
            'slug' => 'hors-catalogue',
            'format' => 'Legacy',
            'usage_ideal' => 'interne',
        ]);

        $this->from(route('site.produits'))
            ->post(route('site.panier.store'), [
                'produit_id' => $produit->id,
                'quantite' => 2,
            ])
            ->assertRedirect(route('site.produits'))
            ->assertSessionHasErrors('produit_id');
    }

    public function test_product_detail_page_is_available_by_slug(): void
    {
        $this->seed(ProduitSeeder::class);

        $produit = Produit::query()->where('slug', 'film-biodegradable')->firstOrFail();

        $this->get(route('site.produits.show', $produit->slug))
            ->assertOk()
            ->assertSee($produit->nom)
            ->assertSee('Commander sur WhatsApp');
    }

    public function test_contact_and_whatsapp_links_use_configured_coordinates(): void
    {
        $this->seed(ProduitSeeder::class);

        $produit = Produit::query()->where('slug', 'petit-transparent')->firstOrFail();

        $this->get(route('site.contact'))
            ->assertOk()
            ->assertSee(config('biosachet.telephone'))
            ->assertSee(config('biosachet.email'))
            ->assertSee('https://wa.me/'.config('biosachet.whatsapp'), false)
            ->assertSee(rawurlencode('Bonjour, je souhaite discuter de mon besoin en sachets biodegradables BioSachet Togo.'), false);

        $this->get(route('site.produits.show', $produit->slug))
            ->assertOk()
            ->assertSee($produit->whatsapp_order_url, false);
    }
}
