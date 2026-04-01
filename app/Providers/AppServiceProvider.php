<?php

namespace App\Providers;

use App\Services\CartService;
use Carbon\CarbonImmutable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Date::use(CarbonImmutable::class);
        setlocale(LC_TIME, 'fr_FR.UTF-8', 'French_France.1252');
        Paginator::useTailwind();

        View::composer('layouts.marketing', function ($view): void {
            $cart = app(CartService::class);

            $view->with([
                'cartCount' => $cart->count(),
                'cartTotal' => $cart->total(),
            ]);
        });
    }
}
