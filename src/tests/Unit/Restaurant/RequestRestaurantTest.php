<?php

namespace Tests\Unit\Restaurant;

use Tests\TestCase;
use App\Models\Restaurant;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestRestaurantTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

        /** @test */
        public function validate_name_field_restaurant() :void
        {
            $city = $this->makeCity();
            $user = $this->getTheAdminUser();
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => '',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45',
                'city_id' => $city->id,
            ])->assertSessionHasErrors('name');
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45',
                'city_id' => $city->id ,
            ])->assertSessionHasNoErrors('name');
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus a fringilla urna, eget aliquam augue. Aliquam cursus leo vitae mauris molestie egestas. Nulla ac dui non ante commodo gravida. Duis vel ipsum congue, malesuada quam sit amet, ullamcorper lorem. Nunc et gravida mauris. Etiam euismod mi at nulla ornare pellentesque. Suspendisse libero libero, facilisis in posuere a, ornare in neque. Maecenas sit amet pretium ante. Sed turpis mi, pretium id commodo quis, faucibus in ligula. Cras non placerat enim, a ultrices libero. Curabitur tempus purus at nulla volutpat volutpat eget eu lectus. Morbi lectus ex, bibendum ac lorem eget, pellentesque',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45',
                'city_id' => $city->id ,
            ])->assertSessionHasErrors('name');
    
        }
    
        /** @test */
        public function validate_description_field() :void
        {
            $city = $this->makeCity();
            $user = $this->getTheAdminUser();
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => '',
                'location' => 'Str. Manole nr. 45',
                'city_id' => $city->id ,
            ])->assertSessionHasNoErrors('description');
    
        }
    
        /** @test */
        public function validate_location_field() :void
        {
            $city = $this->makeCity();
            $user = $this->getTheAdminUser();
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => 'Descriere',
                'location' => '' ,
                'city_id' => $city->id ,
            ])->assertSessionHasErrors('location');
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45' ,
                'city_id' => $city->id,
            ])->assertSessionHasNoErrors('location');
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Marx',
                'description' => 'Descriere',
                'location' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus a fringilla urna, eget aliquam augue. Aliquam cursus leo vitae mauris molestie egestas. Nulla ac dui non ante commodo gravida. Duis vel ipsum congue, malesuada quam sit amet, ullamcorper lorem. Nunc et gravida mauris. Etiam euismod mi at nulla ornare pellentesque. Suspendisse libero libero, facilisis in posuere a, ornare in neque. Maecenas sit amet pretium ante. Sed turpis mi, pretium id commodo quis, faucibus in ligula. Cras non placerat enim, a ultrices libero. Curabitur tempus purus at nulla volutpat volutpat eget eu lectus. Morbi lectus ex, bibendum ac lorem eget, pellentesque',
                'city_id' => $city->id ,
            ])->assertSessionHasErrors('location');
    
        }
    
    
        /** @test */
        public function validate_city_id_field() :void
        {
            $user = $this->getTheAdminUser();
            $city = $this->makeCity();
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45' ,
                'city_id' => '',
            ])->assertSessionHasErrors('city_id');
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45' ,
                'city_id' => 123,
            ])->assertSessionHasErrors('city_id');
    
            $this->actingAs($user)->post('/restaurants',[
                'name' => 'Nume',
                'description' => 'Descriere',
                'location' => 'Str. Manole nr. 45' ,
                'city_id' => $city->id,
            ])->assertSessionHasNoErrors('city_id');
    
        }
}
