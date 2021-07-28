<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy extends Policy
{
    use HandlesAuthorization;

    protected $name = 'invitatie';

    public function before(User $user)
    {
        if($this->searchNameValueInPermissions($user, $this->all))
            return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAnyUser(User $user) :bool
    {
        return true;
    }

    public function viewAnyRestaurant(User $user,Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user,Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }


    public function accept(User $user,Invitation $invitation) :bool
    {
        return $invitation->email == $user->email;
    }



    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invitation  $invitation
     * @return mixed
     */
    public function delete(User $user, Invitation $invitation) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$invitation->restaurant_id,$this->name) || $invitation->email == $user->email;
    }

}
