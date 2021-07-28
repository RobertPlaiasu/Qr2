<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\UserRestaurant;

class Role extends Model
{
    use HasFactory;


    protected $fillable = ['name','description','for_admin'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function userRestaurant()
    {
        return $this->hasMany(UserRestaurant::class);
    }

    public static function employeeRoles()
    {
        return Role::where('for_admin',false)->get();
    }

    public function invitation()
    {
        return $this->hasMany(Invitation::class);
    }
    
    public static function rolesThatCanNotChange() :array
    {
        return ['administrator','patron_restaurant','angajat_restaurant'];
    }
}
