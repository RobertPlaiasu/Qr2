<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRestaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;

    abstract public function before(User $user);
    protected $all = 'all';

    protected function userWithAllPermissions(User $user)
    {
        return $user->load('userRestaurant.role.permissions');
    }

    protected function userWithAllRestaurants(User $user)
    {
        return $user->load('userRestaurant.restaurant');
    }

    protected function userWithAllRestaurantsAndPermissions(User $user)
    {
        return $user->load('userRestaurant.role.permissions','userRestaurant.restaurant');
    }

    protected function searchNameValueInPermissions(User $user,string $value) :bool
    {

        $user = $this->userWithAllPermissions($user);

        foreach($user->userRestaurant as $userRestaurant)
            foreach($userRestaurant->role->permissions as $permission)
                if($permission->name === $value)
                    return true;
        return false;

    }

    protected function searchRestaurantIdforTheUser(User $user ,int $restaurantId) :bool
    {
        $user = $this->userWithAllRestaurantsAndPermissions($user);

        foreach($user->userRestaurant as $userRestaurant)
            if($userRestaurant->restaurant->id === $restaurantId)
                return true;

        return false;
    }

    protected function verifyIfUserHasTheRestaurantAndPermission(User $user ,int $restaurantId,string $value) :bool
    {
        $user = $this->userWithAllPermissions($user);

        foreach($user->userRestaurant as $userRestaurant)
        {
            if($userRestaurant->restaurant)
            {
                if($userRestaurant->restaurant->id === $restaurantId)
                {
                    foreach($userRestaurant->role->permissions as $permission)
                    {
                        if($permission->name === $value)
                            return true;
                    }
                }
            }
        }

        return false;
    }

}
