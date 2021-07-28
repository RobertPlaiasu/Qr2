<?php

namespace App\Observers;

use App\Models\Restaurant;
use App\Models\UserRestaurant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestaurantObserver
{
    /**
     * Handle the Restaurant "created" event.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return void
     */
    public function created(Restaurant $restaurant)
    {
        $restaurant->slug  = $restaurant->combineNameWithId();
        $restaurant->save();
        if($user = Auth::user())
        {
            $user->load('userRestaurant.role');
            foreach($user->userRestaurant as $userRestaurant)
            {
                if($userRestaurant->role->name === 'patron_restaurant'  &&  $userRestaurant->restaurant_id === null)
                {
                    $userRestaurant->restaurant_id = $restaurant->id;
                    $userRestaurant->save();
                    break;
                }
            }
        }
    }

    /**
     * Handle the Restaurant "updated" event.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return void
     */
    public function updated(Restaurant $restaurant)
    {
        //
    }

    /**
     * Handle the Restaurant "deleted" event.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return void
     */
    public function deleted(Restaurant $restaurant)
    {
        if($user = Auth::user())
        {
            $user->load('userRestaurant.role');
            foreach($user->userRestaurant as $userRestaurant)
            {
                if($userRestaurant->role->name === 'patron_restaurant'  && $userRestaurant->restaurant_id == $restaurant->id)
                {
                    $userRestaurant->restaurant_id = null;
                    $userRestaurant->save();
                    break;
                }
            }

            DB::table('user_restaurants')->where('restaurant_id',$restaurant->id)->delete();
        }
    }

    /**
     * Handle the Restaurant "restored" event.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return void
     */
    public function restored(Restaurant $restaurant)
    {
        //
    }

    /**
     * Handle the Restaurant "force deleted" event.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return void
     */
    public function forceDeleted(Restaurant $restaurant)
    {
        //
    }
}
