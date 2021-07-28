<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory,SlugTrait;

    protected $fillable = ['name','restaurant_id'];

    public $qrExtension = ".svg";

    public $pathQr = 'app/public/qr/';

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class);
    }



    public function path(bool $fullPath = true ) :string
    {
        if ( $fullPath ) return  '/menus/' . $this->slug;

        return $restaurant->path().'/' . $this->slug;
    }

    public function createQr() :void 
    {
        $targetFile = storage_path( $this->pathQr . $this->id . $this->qrExtension );
        QrCode::generate( config('app.url') . $this->path(), $targetFile);
    }

    public function deleteQr() :void 
    {
        Storage::disk('public')->delete('qr/' . $this->id . $this->qrExtension);
    }

    public function deleteProductsPhotos() :void 
    {
        foreach($this->categories as $category)
            if($category)
                $category->deleteProductsPhotos();
    }

}
