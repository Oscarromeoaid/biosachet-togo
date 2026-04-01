<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\CommandeDocumentController;
use App\Http\Controllers\Admin\CommandePaiementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockMatiereController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicOrderTrackingController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/produits', [SiteController::class, 'produits'])->name('site.produits');
Route::get('/produits/{slug}', [SiteController::class, 'produit'])->name('site.produits.show');
Route::get('/notre-processus', [SiteController::class, 'process'])->name('site.process');
Route::get('/impact-environnemental', [SiteController::class, 'impact'])->name('site.impact');
Route::get('/contact', [SiteController::class, 'contact'])->name('site.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('site.contact.store');
Route::get('/panier', [CartController::class, 'index'])->name('site.panier');
Route::post('/panier', [CartController::class, 'store'])->name('site.panier.store');
Route::patch('/panier/{produit}', [CartController::class, 'update'])->name('site.panier.update');
Route::delete('/panier/{produit}', [CartController::class, 'destroy'])->name('site.panier.destroy');
Route::post('/commander', [CartController::class, 'checkout'])->name('site.commande.store');
Route::get('/commande/confirmee', [CartController::class, 'confirmation'])->name('site.commande.confirmee');
Route::get('/suivi-commande', [PublicOrderTrackingController::class, 'index'])->name('site.commande.suivi');
Route::post('/suivi-commande', [PublicOrderTrackingController::class, 'lookup'])->name('site.commande.lookup');
Route::get('/suivi-commande/{token}', [PublicOrderTrackingController::class, 'show'])->name('site.commande.suivi.show');
Route::get('/suivi-commande/{token}/devis', [PublicOrderTrackingController::class, 'quote'])->name('site.commande.devis');

Route::get('/dashboard', function () {
    return auth()->user()?->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('site.home');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/alertes', [AlertController::class, 'index'])->name('alertes.index');

    Route::middleware('admin.role:super_admin,operations,finance')->group(function () {
        Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
        Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
        Route::get('/commandes/{commande}/devis', [CommandeDocumentController::class, 'quote'])->name('commandes.devis');
    });

    Route::middleware('admin.role:super_admin,operations')->group(function () {
        Route::resource('produits', ProduitController::class);
        Route::resource('clients', ClientController::class);
        Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
        Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
        Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
        Route::match(['put', 'patch'], '/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
        Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
    });

    Route::middleware('admin.role:super_admin,finance')->group(function () {
        Route::post('/commandes/{commande}/paiements', [CommandePaiementController::class, 'store'])->name('commandes.paiements.store');
        Route::delete('/commandes/{commande}/paiements/{paiement}', [CommandePaiementController::class, 'destroy'])->name('commandes.paiements.destroy');
        Route::get('/rapports', [ReportController::class, 'index'])->name('rapports.index');
        Route::get('/rapports/impact/pdf', [ReportController::class, 'environmentalPdf'])->name('rapports.impact.pdf');
        Route::get('/rapports/impact/excel', [ReportController::class, 'environmentalExcel'])->name('rapports.impact.excel');
        Route::get('/rapports/finance/pdf', [ReportController::class, 'financialPdf'])->name('rapports.finance.pdf');
        Route::get('/rapports/finance/excel', [ReportController::class, 'financialExcel'])->name('rapports.finance.excel');
        Route::get('/rapports/production-types/excel', [ReportController::class, 'productionTypesExcel'])->name('rapports.production-types.excel');
        Route::get('/rapports/production-types/csv', [ReportController::class, 'productionTypesCsv'])->name('rapports.production-types.csv');
    });

    Route::middleware('admin.role:super_admin,operations,stock')->group(function () {
        Route::resource('productions', ProductionController::class);
        Route::resource('stocks-matieres', StockMatiereController::class)
            ->parameters(['stocks-matieres' => 'stockMatiere']);
    });

    Route::middleware('admin.role:super_admin')->group(function () {
        Route::get('/activites', [ActivityLogController::class, 'index'])->name('activites.index');
        Route::get('/admins', [AdminUserController::class, 'index'])->name('admin-users.index');
        Route::get('/admins/{user}/edit', [AdminUserController::class, 'edit'])->name('admin-users.edit');
        Route::put('/admins/{user}', [AdminUserController::class, 'update'])->name('admin-users.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
