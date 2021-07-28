<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRestaurant;
use App\Models\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRestaurantPolicy extends Policy
{
    use HandlesAuthorization;

    protected $name = 'atribuire_rol';

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
    public function viewAny(User $user,Restaurant $restaurant) :bool
    {
        return $this->searchRestaurantIdforTheUser($user,$restaurant->id);
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user) :bool
    {
        return false;
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserRestaurant  $userRestaurant
     * @return bool
     */
    public function update(User $user,UserRestaurant $userRestaurant, Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserRestaurant  $userRestaurant
     * @return bool
     */
    public function delete(User $user,UserRestaurant $userRestaurant,Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name) || $userRestaurant->user->id == $user->id;
    }


}
