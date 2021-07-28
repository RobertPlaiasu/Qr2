<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy extends Policy
{
    use HandlesAuthorization;

    protected $name = "meniu";

    public function before(User $user)
    {
        if($this->searchNameValueInPermissions($user, $this->all))
            return true;
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function view(?User $user, Menu $menu)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user,Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name) && !$restaurant->menu;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return bool
     */
    public function update(User $user,Menu $menu,Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return bool
     */
    public function delete(User $user, Menu $menu,Restaurant $restaurant) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return bool
     */
    public function restore(User $user, Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return bool
     */
    public function forceDelete(User $user, Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    public function downloadQr(User $user,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }
}
