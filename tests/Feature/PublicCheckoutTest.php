<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Produit;
use App\Services\CommandeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_add_items_to_cart_and_continue_on_whatsapp(): void
    {
        $produit = Produit::factory()->create([
            'nom' => 'SACHET MOYEN SOUPLE',
            'slug' => 'moyen-souple',
            'format' => 'Medium',
            'usage_ideal' => 'pain, beignets, fruits',
            'prix_unitaire' => 35,
        ]);

        $this->post(route('site.panier.store'), [
            'produit_id' => $produit->id,
            'quantite' => 3,
        ])->assertRedirect();

        $response = $this->post(route('site.commande.store'), [
            'nom' => 'Boutique Demo',
            'telephone' => '90112233',
            'email' => 'demo@client.tg',
            'type' => 'commerce',
            'ville' => 'Lome',
            'date_livraison' => now()->addDay()->toDateString(),
        ]);

        $response->assertRedirect();
        $location = $response->headers->get('Location');
        $this->assertNotNull($location);
        $this->assertStringContainsString('https://wa.me/'.config('biosachet.whatsapp'), $location);
        $this->assertStringContainsString(rawurlencode('Bonjour, je souhaite passer commande via WhatsApp.'), $location);
        $this->assertStringContainsString(rawurlencode('Boutique Demo'), $location);
        $this->assertStringContainsString(rawurlencode('SACHET MOYEN SOUPLE x3'), $location);
        $this->assertDatabaseCount('clients', 0);
        $this->assertDatabaseCount('commandes', 0);
        $this->assertNotSame([], session('site_cart', []));
    }

    public function test_checkout_fails_when_cart_is_empty(): void
    {
        $response = $this->from(route('site.panier'))->post(route('site.commande.store'), [
            'nom' => 'Boutique Demo',
            'telephone' => '90112233',
            'email' => 'demo@client.tg',
            'type' => 'commerce',
            'ville' => 'Lome',
        ]);

        $response->assertRedirect(route('site.panier'));
        $response->assertSessionHasErrors('panier');
        $this->assertDatabaseCount('commandes', 0);
    }

    public function test_public_checkout_no_longer_requires_a_payment_method(): void
    {
        $produit = Produit::factory()->create([
            'nom' => 'PETIT SACHET TRANSPARENT',
            'slug' => 'petit-transparent',
            'format' => 'Small',
            'usage_ideal' => 'sucre, arachides, epices, fruits secs',
            'prix_unitaire' => 20,
        ]);

        $this->post(route('site.panier.store'), [
            'produit_id' => $produit->id,
            'quantite' => 2,
        ])->assertRedirect();

        $response = $this->from(route('site.panier'))->post(route('site.commande.store'), [
            'nom' => 'Client Test',
            'telephone' => '90112233',
            'email' => 'client@test.tg',
            'type' => 'commerce',
            'ville' => 'Lome',
        ]);

        $response->assertRedirect();
        $location = $response->headers->get('Location');
        $this->assertNotNull($location);
        $this->assertStringContainsString('https://wa.me/'.config('biosachet.whatsapp'), $location);
        $this->assertDatabaseCount('commandes', 0);
    }

    public function test_visitor_can_track_order_and_download_quote(): void
    {
        $produit = Produit::factory()->create([
            'nom' => 'FILM PLASTIQUE BIODEGRADABLE',
            'slug' => 'film-biodegradable',
            'format' => 'Roll/Sheet',
            'usage_ideal' => 'emballage alimentaire, remplacement cellophane, sachets personnalises',
            'prix_unitaire' => 30,
        ]);

        $client = Client::factory()->create([
            'nom' => 'Client Suivi',
            'telephone' => '90112233',
        ]);

        $commande = app(CommandeService::class)->store([
            'client_id' => $client->id,
            'statut' => 'en_attente',
            'paiement' => 'en_attente',
            'methode_paiement' => 'flooz',
            'date_livraison' => now()->addDay()->toDateString(),
            'produits' => [
                [
                    'produit_id' => $produit->id,
                    'quantite' => 2,
                    'prix_unitaire' => 30,
                ],
            ],
        ]);

        $lookup = $this->post(route('site.commande.lookup'), [
            'reference' => $commande->reference,
            'telephone' => $client->telephone,
        ]);

        $lookup->assertRedirect(route('site.commande.suivi.show', $commande->suivi_token));
        $this->get(route('site.commande.suivi.show', $commande->suivi_token))
            ->assertOk()
            ->assertSee(rawurlencode('Bonjour, je souhaite un suivi pour la commande '.$commande->reference.'.'), false);
        $this->get(route('site.commande.devis', $commande->suivi_token))->assertOk();
    }
}
