<?php

namespace App\Jobs;

use App\Models\Role;
use App\Models\UserRestaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteRestaurantsWhereSubscriptionsExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach(UserRestaurant::where('role_id',Role::where('name','patron_restaurant')->first()->id)->get() as $userRestaurant)
        {
            if($userRestaurant->user->subscription('subscription')->ended())
            {
                if($userRestaurant->restaurant)
                {
                    $userRestaurant->restaurant->deleteQrAndProductsPhotos();
                    $userRestaurant->restaurant->delete();
                }
                $userRestaurant->delete();
            }
        }
    }
}
