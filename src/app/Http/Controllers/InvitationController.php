<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRestaurant;
use App\Http\Requests\CreateInvitationRequest;
use App\Services\NavService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of the resource specific to a user.
     *
     * @return \Inertia\Inertia
     */
    public function index()
    {
        $this->authorize('viewAnyUser',Invitation::class);
        $invitations = Invitation::where('email', Auth::user()->email)->get();

        $restaurants = $invitations->map(function ($inv){
            return $inv->restaurant;
        });

        $roles = $invitations->map(function ($inv){
            return $inv->role;
        });

        return Inertia::render('Invitation/User', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'invitations' => $invitations,
            'restaurants' => $restaurants,
            'roles' => $roles,
            'title' => "Invitații | " . Auth::user()->name . " - DigitalMenu"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('create',[Invitation::class,$restaurant]);
        $roles = Role::employeeRoles();
        $restaurant->uri = $restaurant->path();

        return Inertia::render('Invitation/Create', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'restaurant' => $restaurant,
            'roles' => $roles,
            'title' => 'Creare invitație | ' . $restaurant->name . ' - DigitalMenu'
        ]);
    }

    public function store(Restaurant $restaurant,CreateInvitationRequest $request)
    {
        $this->authorize('create',[Invitation::class,$restaurant]);


        if(Invitation::where('restaurant_id',$restaurant->id)
        ->where('role_id',$request->role_id)
        ->where('email',$request->email)->count() > 0 )
        {
            return Redirect::to($restaurant->path() . '/invitations/create')->withErrors(['Invitatia deja exista!']);
        }

        if (User::where('email',$request->email)->first())
            if(UserRestaurant::where('restaurant_id',$restaurant->id)
            ->where('role_id',$request->role_id)
            ->where('user_id',User::where('email',$request->email)->first()->id)->count() > 0
            )
            return Redirect::to($restaurant->path() . '/invitations/create')->withErrors(['Exista deja un user cu cu acest rol!']);

        if (Role::where('id', $request->role_id)->first()->for_admin != false)
                return Redirect::to($restaurant->path() . '/invitations/create')->withErrors(['Rolul nu este permis!']);

        Invitation::create([
            'restaurant_id' => $restaurant->id,
            'role_id' => $request->role_id,
            'email' => $request->email,
        ]);

        return Redirect::to('/staff'. $restaurant->path());
    }

    public function accept(Invitation $invitation)
    {
        $this->authorize('accept',$invitation);
        UserRestaurant::create([
            'role_id' => $invitation->role_id,
            'restaurant_id' => $invitation->restaurant_id,
            'user_id' => User::where('email',$invitation->email)->first()->id,
        ]);

        $restaurant = Restaurant::where('id',$invitation->restaurant_id)->first();

        $invitation->delete();
        return Redirect::to($restaurant->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        $this->authorize('delete',$invitation);
        $invitation->delete();

        return Redirect::to('/dashboard');
    }
}
