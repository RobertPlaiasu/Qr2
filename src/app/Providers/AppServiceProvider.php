<?php

namespace App\Providers;

use App\Models\Menu;
use App\Observers\MenuObserver;
use App\Models\Restaurant;
use App\Observers\RestaurantObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Invitation;
use App\Observers\InvitationObserver;
use App\Models\Product;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::observe( MenuObserver::class );
        Restaurant::observe( RestaurantObserver::class);
        Invitation::observe(InvitationObserver::class);
        Product::observe(ProductObserver::class);
    }
}
