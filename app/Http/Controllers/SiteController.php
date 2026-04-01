<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Services\DashboardMetricsService;

class SiteController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $metrics)
    {
    }

    public function home()
    {
        return view('site.home', [
            'produits' => Produit::query()->publicCatalog()->get(),
            'metrics' => $this->metrics->get(),
            'segments' => [
                [
                    'titre' => 'Vente de detail',
                    'description' => 'Le petit sachet transparent sert aux vendeuses et boutiques qui conditionnent sucre, arachides, epices ou fruits secs.',
                ],
                [
                    'titre' => 'Alimentaire quotidien',
                    'description' => 'Le sachet moyen souple supporte pain, beignets et fruits avec une sensation proche du plastique classique.',
                ],
                [
                    'titre' => 'Courses et transport',
                    'description' => 'Le grand sachet solide joue le role de sac de courses pour des charges de 2 a 4 kg.',
                ],
                [
                    'titre' => 'Film et emballage',
                    'description' => 'Le film biodegradable remplace le cellophane pour emballage fin, decoupe et scellage a chaud.',
                ],
            ],
            'advantages' => [
                '4 references precises pour couvrir petite vente, alimentaire, shopping bag et film de conditionnement.',
                'Recettes et notes de production documentees directement dans l admin pour garder une execution reguliere.',
                'Prise de commande centralisee sur WhatsApp pour valider les besoins avant toute suite commerciale.',
                'Production de lancement structuree autour de 500 sorties par jour avec suivi journalier.',
            ],
            'milestones' => [
                ['label' => 'Catalogue', 'value' => '4 types exacts'],
                ['label' => 'Ancrage local', 'value' => 'Lome, Togo'],
                ['label' => 'Prix cible', 'value' => '20 a 50 FCFA'],
                ['label' => 'Mini-factory', 'value' => 'An 2'],
            ],
            'faq' => [
                [
                    'question' => 'Quel sachet choisir pour les petites denrees ?',
                    'answer' => 'Le petit sachet transparent est prevu pour sucre, arachides, epices et fruits secs avec une tenue semi-rigide.',
                ],
                [
                    'question' => 'Quel modele convient au pain ou aux beignets ?',
                    'answer' => 'Le sachet moyen souple a ete pense pour ce type de charge et garde une texture proche du plastique souple habituel.',
                ],
                [
                    'question' => 'Pouvez-vous fournir du film a decouper ?',
                    'answer' => 'Oui. Le film plastique biodegradable est ultra fin, transparent, decoupable et scellable a chaud.',
                ],
            ],
        ]);
    }

    public function produits()
    {
        return view('site.produits', [
            'produits' => Produit::query()->publicCatalog()->get(),
            'useCases' => [
                ['titre' => 'Condiments et denrees seches', 'description' => 'Sucre, arachides, epices et fruits secs avec un sachet fin, propre et visible.'],
                ['titre' => 'Boulangerie et snacking', 'description' => 'Pain, beignets et fruits dans un sachet souple qui reste agreable a manipuler.'],
                ['titre' => 'Courses et commerce mobile', 'description' => 'Sacs de transport plus solides pour tomates, oranges et petits achats groupes.'],
                ['titre' => 'Film de conditionnement', 'description' => 'Alternative au cellophane pour emballage fin, personnalisation et decoupe a la demande.'],
            ],
        ]);
    }

    public function produit(string $slug)
    {
        $produit = Produit::query()
            ->publicCatalog()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('site.produit-show', [
            'produit' => $produit,
            'relatedProduits' => Produit::query()
                ->publicCatalog()
                ->where('id', '!=', $produit->id)
                ->get(),
        ]);
    }

    public function process()
    {
        return view('site.process', [
            'steps' => [
                [
                    'titre' => 'Extraction',
                    'description' => 'Le manioc est transforme en amidon vegetal local.',
                    'detail' => 'La qualite de la matiere premiere est verifiee des la reception pour garantir regularite et rendement.',
                ],
                [
                    'titre' => 'Gelatinisation',
                    'description' => "L'amidon est chauffe avec eau, glycerine et vinaigre selon la recette du type produit.",
                    'detail' => 'Chaque reference suit une proportion differente pour jouer sur la transparence, la souplesse ou la solidite.',
                ],
                [
                    'titre' => 'Moulage',
                    'description' => 'La matiere est etalee finement, en epaisseur moyenne ou en double couche selon le sachet vise.',
                    'detail' => 'Le petit transparent, le moyen souple, le grand solide et le film n utilisent pas la meme epaisseur de pose.',
                ],
                [
                    'titre' => 'Sechage',
                    'description' => 'Le sechage varie de 6 a 18 heures selon la recette et l epaisseur.',
                    'detail' => 'Le controle du temps de sechage conditionne la clarte, la tenue et la maniabilite du produit fini.',
                ],
                [
                    'titre' => 'Decoupe',
                    'description' => 'Les sachets et films sont tailles, renforces si besoin puis prepares pour la vente.',
                    'detail' => 'Les poignets des grands sachets peuvent etre renforces et le film peut etre decoupe ou scelle a chaud.',
                ],
            ],
            'qualityPoints' => [
                'Recettes standardisees par type de sachet dans l interface admin.',
                'Controle visuel des lots avant mise en stock.',
                'Suivi quotidien des volumes par type pour ajuster la planification.',
                'Trajectoire d industrialisation progressive vers une mini-factory locale.',
            ],
        ]);
    }

    public function impact()
    {
        return view('site.impact', [
            'metrics' => $this->metrics->get(),
            'pillars' => [
                [
                    'titre' => 'Moins de plastique',
                    'description' => 'Chaque sachet biodegradable distribue remplace un emballage a usage unique plus polluant.',
                ],
                [
                    'titre' => 'Plus de valeur locale',
                    'description' => 'Le manioc togolais devient une matiere industrielle utile pour une economie circulaire plus concrete.',
                ],
                [
                    'titre' => 'Emplois et sensibilisation',
                    'description' => 'La production cree des postes, renforce les competences et soutient des relais educatifs.',
                ],
            ],
            'targets' => [
                ['label' => 'Objectif capacite an 2', 'value' => 'mini-factory locale'],
                ['label' => 'Distribution prioritaire', 'value' => 'Lome et grands axes commerciaux'],
                ['label' => 'Programme ecoles', 'value' => config('biosachet.partner_schools').' partenaires'],
            ],
        ]);
    }

    public function contact()
    {
        return view('site.contact', [
            'channels' => [
                ['label' => 'Telephone', 'value' => config('biosachet.telephone')],
                ['label' => 'Email', 'value' => config('biosachet.email')],
                ['label' => 'WhatsApp', 'value' => '+'.config('biosachet.whatsapp')],
                ['label' => 'Base operationnelle', 'value' => config('biosachet.adresse')],
            ],
            'quoteSteps' => [
                'Vous decrivez sur WhatsApp le type de sachet ou de film, le volume et la frequence.',
                'Nous proposons la reference adaptee, le prix et le delai.',
                'La commande est validee manuellement avec vous sur WhatsApp.',
                'Le lot est prepare pour retrait ou livraison locale selon le cas.',
            ],
            'faq' => [
                [
                    'question' => 'Acceptez-vous les demandes recurrentes ?',
                    'answer' => 'Oui. Les commandes hebdomadaires ou mensuelles sont justement les plus interessantes pour stabiliser la production.',
                ],
                [
                    'question' => 'Peut-on commander sans email ?',
                    'answer' => 'Oui. Le telephone et WhatsApp restent adaptes au contexte local et suffisent pour lancer un devis rapide.',
                ],
                [
                    'question' => 'Travaillez-vous hors de Lome ?',
                    'answer' => 'Oui, selon les volumes et la planification logistique vers Tsevie, Atakpame, Sokode, Kara ou d autres zones.',
                ],
            ],
        ]);
    }
}
