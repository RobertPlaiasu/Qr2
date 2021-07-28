<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory, SlugTrait, StorePictureTrait;

    protected $fillable = ['name', 'description', 'location', 'city_id', 'picture'];

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }

    public function invitation()
    {
        return $this->hasMany(Invitation::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function userRestaurant()
    {
        return $this->hasMany(UserRestaurant::class);
    }

    public function path(): String
    {
        return '/restaurants/' . $this->slug;
    }

    public static function generateURIs($customShow = false): Collection
    {
        return  Restaurant::all()->map(function ($res) {
            return $res->path();
        });
    }

    public function deleteQrAndProductsPhotos(): void
    {
        $this->deletePhoto();
        if ($this->menu) {
            $this->menu->deleteQr();
            $this->menu->deleteProductsPhotos();
        }
    }
}
