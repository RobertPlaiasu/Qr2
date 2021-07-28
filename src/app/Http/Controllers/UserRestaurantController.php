<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\UserRestaurant;
use App\Http\Requests\AssignRoleCreateRequest;
use App\Http\Requests\AssignRoleUpdateRequest;
use App\Services\NavService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class UserRestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Inertia
     */
    public function create()
    {
        $this->authorize('create',[UserRestaurant::class]);

        return Inertia::render('UserRestaurant/Create', [
            'role_id' => Role::where('name', 'patron_restaurant')->first()->id,
            'user' => (new NavService)->generateNavbarUser(),
            'users' => User::all(),
            'title' => 'Creare patron de restaurant - DigitalMenu'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssignRoleCreateRequest  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function store(AssignRoleCreateRequest $request)
    {
        $this->authorize('create',[UserRestaurant::class]);
        $userRestaurant = UserRestaurant::create([
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
            'restaurant_id' => $request->restaurant_id
        ]);

        return Redirect::to('/admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\UserRestaurant  $userRestaurant
     * @return \Inertia\Inertia
     */
    public function edit(Restaurant $restaurant, UserRestaurant $userRestaurant)
    {
        $this->authorize('update',[$userRestaurant,$restaurant]);
        $authUser = Auth::user();
        $menu = $restaurant->menu ?? null;

        $availableRoles = Role::where('name', 'angajat_restaurant')
            ->orWhere('name', 'patron_restaurant')
            ->get();
        $currentRoles = UserRestaurant::where('user_id', $userRestaurant->user->id)
            ->where('restaurant_id', $restaurant->id)
            ->get();

        return Inertia::render('UserRestaurant/Edit', [
            'availableRoles' => $availableRoles,
            'currentRoles' => $currentRoles,
            'userRestaurant' => $userRestaurant,
            'user' => $userRestaurant->user,
            'authUser' =>$authUser,
            'restaurant' => $restaurant->id,
            'menu' => ( $menu != null ) ? $menu->path() : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssignRoleUpdateRequest  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\UserRestaurant  $userRestaurant
     * @return \Illuminate\Http\Response
     */
    public function update(AssignRoleUpdateRequest $request, Restaurant $restaurant, UserRestaurant $userRestaurant)
    {
        $this->authorize('update',[$userRestaurant,$restaurant]);
        $userRestaurant->role_id = $request->role_id;
        $userRestaurant->save();

        return Redirect::to('/assign_roles' . $restaurant->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\UserRestaurant  $userRestaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant, UserRestaurant $userRestaurant)
    {
        $this->authorize('delete',[$userRestaurant,$restaurant]);
        $userRestaurant->delete();
        return Redirect::to($restaurant->path());
    }
}
