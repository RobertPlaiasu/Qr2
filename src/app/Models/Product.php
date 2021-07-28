<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory,StorePictureTrait;


    protected $fillable = ['name','price','picture','weight','available','category_id'];

    public function category()
    {

        return $this->belongsTo(Category::class);

    }

    public function promos()
    {
        return $this->belongsToMany(Product::class);
    }
}
