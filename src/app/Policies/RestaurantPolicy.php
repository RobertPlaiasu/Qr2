<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\UserRestaurant;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy extends Policy
{
    use HandlesAuthorization;

    private $name = 'restaurant';

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
    public function viewAny(User $user) :bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return bool
     */
    public function view(?User $user,Restaurant $restaurant) :bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user) :bool
    {
        return $this->determineIfRestaurantOwnerHasNoRestaurant($user);
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return bool
     */
    public function update(User $user, Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return bool
     */
    public function delete(User $user, Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return bool
     */
    public function restore(User $user, Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return bool
     */
    public function forceDelete(User $user, Restaurant $restaurant) :bool
    {
        return $this->determineIfTheUserCanUseTheRestaurant($user,$restaurant->id);
    }

    private function determineIfRestaurantOwnerHasNoRestaurant(User $user) :bool
    {
        if(UserRestaurant::where('user_id',$user->id)
        ->where('role_id',Role::where('name','patron_restaurant')->first()->id)
        ->where('restaurant_id',null)->first())
        {
            return true;
        }
        return false;
    }


}
