<?php 

namespace App\Models;
use Illuminate\Support\Str;


trait SlugTrait 
{


    public function combineNameWithId() :string
    {
        return $this->id . '-' . Str::slug($this->name);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


}