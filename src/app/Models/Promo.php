<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Promo extends Model
{
    use HasFactory,StorePictureTrait;

    protected $fillable = ['menu_id','price','weight','name','picture','expire'];

    protected $dates = ['expire'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    
}
