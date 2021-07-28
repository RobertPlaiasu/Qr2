<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       'App\Models\Restaurant' => 'App\Policies\RestaurantPolicy',
       'App\Models\County' => 'App\Policies\CountyPolicy',
       'App\Models\Permission' => 'App\Policies\PermissionPolicy',
       'App\Models\City' => 'App\Policies\CityPolicy',
       'App\Models\UserRestaurant' => 'App\Policies\UserRestaurantPolicy',
       'App\Models\Menu' => 'App\Policies\MenuPolicy',
       'App\Models\Category' => 'App\Policies\CategoryPolicy',
       'App\Models\Role' => 'App\Policies\RolePolicy',
       'App\Models\Product' => 'App\Policies\ProductPolicy',
       'App\Models\Promo' => 'App\Policies\PromoPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)->subject('Digital Menu | Înregistrare cont')->view(
                'emails.register',
                ['url' => $url]
            );
        });
    }
}
