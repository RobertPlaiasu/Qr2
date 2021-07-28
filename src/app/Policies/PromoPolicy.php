<?php

namespace App\Policies;

use App\Models\Promo;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromoPolicy extends Policy
{
    use HandlesAuthorization;

    private $name = 'promotie';

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
    public function viewAny(User $user,Menu $menu)
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Promo  $promo
     * @return mixed
     */
    public function view(User $user,Menu $menu,Promo $promo)
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user,Menu $menu)
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Promo  $promo
     * @return mixed
     */
    public function update(User $user,Menu $menu,Promo $promo)
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Promo  $promo
     * @return mixed
     */
    public function delete(User $user,Menu $menu,Promo $promo)
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

}
