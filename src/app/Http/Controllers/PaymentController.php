<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\NavService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SubscriptionCreateRequest;
use App\Models\UserRestaurant;
use App\Models\Role;

class PaymentController extends Controller
{
    public function prices()
    {
        return Inertia::render('Price',[
            'price' => '18.99 €',
        ]);
    }

    public function subscribe()
    {
        return Inertia::render('Subscription',[
            'title' => 'Abonament',
            'currentUser' => (new NavService())->generateNavbarUser(),
            'plan' => config('custom_stripe_config.cashier_subscription_plan'),
            'stripeKey' => config('custom_stripe_config.stripe_key'),
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    public function createSubscription(SubscriptionCreateRequest $request)
    {
        if($request->plan != config('custom_stripe_config.cashier_subscription_plan'))
            return Redirect::to(route('subscribe'))->withErrors('Planul nu este ales !');


        $options = [
            'name' => $request->last_name . " " . $request->first_name,
            'email' => auth()->user()->email,
            'address' => [
                'city' => $request->city,
                'country' => "RO",
                'line1' => $request->address,
                'state' => $request->state,
                'postal_code' => $request->zip_code,
            ],
        ];


        auth()->user()->newSubscription('subscription',$request->plan)->create($request->payment_method_id,$options);

        UserRestaurant::create(
        [
            'user_id' => auth()->id(),
            'role_id' => Role::where('name','patron_restaurant')->first()->id,
            'restaurant_id' => null,
        ]);
        UserRestaurant::create(
        [
            'user_id' => auth()->id(),
            'role_id' => Role::where('name','patron_restaurant')->first()->id,
            'restaurant_id' => null,
        ]);
        UserRestaurant::create(
        [
            'user_id' => auth()->id(),
            'role_id' => Role::where('name','patron_restaurant')->first()->id,
            'restaurant_id' => null,
        ]);

        return Redirect::to('/dashboard');
    }

}
