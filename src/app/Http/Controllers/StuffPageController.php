<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\UserRestaurant;
use App\Services\NavService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class StuffPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Restaurant $restaurant)
    {
        $this->authorize('viewAny', [UserRestaurant::class, $restaurant]);
        $user = Auth::user();
        $restaurant->uri = $restaurant->path();

        $invitations = Invitation::where('restaurant_id', $restaurant->id)->get()->map(
            function ($invitation) {
                return (object) array(
                    'email' => $invitation->email,
                    'role' => Role::where('id', $invitation->role_id)->first()->name
                );
            }
        );

        $userRestaurants = UserRestaurant::where('restaurant_id', $restaurant->id)->get()->map(
            function ($userRestaurant)
            {
                return (object) array(
                    'id' => $userRestaurant->id,
                    'user' => $userRestaurant->user,
                    'role' => $userRestaurant->role,
                    'restaurant' => $userRestaurant->restaurant
                );
            }
        );

        return Inertia::render('Stuff', [
            'userRestaurants' => $userRestaurants,
            'user' => (new NavService)->generateNavbarUser(),
            'restaurant' => $restaurant,
            'roles' => Role::where('for_admin',false)->get(),
            'isAdmin' => optional(Auth::user())->can('update', $restaurant),
            'invitations' => $invitations,
            'title' => "Angajați | " . $restaurant->name . " - DigitalMenu"
        ]);
    }
}
