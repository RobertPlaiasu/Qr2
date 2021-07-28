<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy extends Policy
{
    use HandlesAuthorization;

    private $name = 'produs';
    private $nameChangeAvailability = 'produs_status';

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
    public function viewAny(User $user,Category $category) :bool
    {
        $category = $category->load('menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$category->menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user,Category $category) :bool
    {
        $category = $category->load('menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$category->menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function update(User $user, Product $product) :bool
    {
        $product = $product->load('category.menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$product->category->menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function delete(User $user, Product $product) :bool
    {
        $product = $product->load('category.menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$product->category->menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function restore(User $user, Product $product) :bool
    {
        $product = $product->load('category.menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$product->category->menu->restaurant->id,$this->name);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function forceDelete(User $user, Product $product) :bool
    {
        $product = $product->load('category.menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$product->category->menu->restaurant->id,$this->name);
    }

    public function changeAvailabilty(User $user, Product $product) :bool
    {
        $product = $product->load('category.menu.restaurant');
        return $this->verifyIfUserHasTheRestaurantAndPermission($user,$product->category->menu->restaurant->id,$this->nameChangeAvailability)
        || $this->verifyIfUserHasTheRestaurantAndPermission($user,$product->category->menu->restaurant->id,$this->name);
    }

}
