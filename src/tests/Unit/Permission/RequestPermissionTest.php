<?php

namespace Tests\Unit\Permission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Permission;
use Tests\Feature\DataForAuthorizationTrait;

class RequestPermissionTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

     /** @test */
     public function validate_name_field()
     {
         $user = $this->getTheAdminUser();
         $this->actingAs($user)->post('/permissions',[
             'name' => '',
             'description' => 'Descriere',
         ])->assertSessionHasErrors('name');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'a',
             'description' => 'Descriere',
         ])->assertSessionHasErrors('name');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
             'description' => 'Descriere',
         ])->assertSessionHasErrors('name');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 2,
             'description' => 'Descriere',
         ])->assertSessionHasErrors('name');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'Nume',
             'description' => 'Descriere',
         ])->assertSessionHasNoErrors('name');
     }
 
     /** @test */
     public function validate_description_field()
     {
         $user = $this->getTheAdminUser();
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'Nume',
             'description' => '',
         ])->assertSessionHasErrors('description');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'Nume',
             'description' => 'aaaa',
         ])->assertSessionHasErrors('description');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'Nume',
             'description' => 'lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
         ])->assertSessionHasErrors('description');
 
         $this->actingAs($user)->post('/permissions',[
             'name' => 'Nume',
             'description' => 'Description',
         ])->assertSessionHasNoErrors('description');
     }

}
