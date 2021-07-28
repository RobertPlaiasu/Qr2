<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy extends Policy
{
    use HandlesAuthorization;

    protected $name = "categorie";

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
    public function viewAny(User $user,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function view(User $user,Category $category,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function update(User $user,Category $category,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function delete(User $user,Category $category,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function restore(User $user, Category $category,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function forceDelete(User $user, Category $category,Menu $menu) :bool
    {
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$menu->restaurant->id,$this->name);
    }
}
