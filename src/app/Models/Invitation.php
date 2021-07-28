<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['role_id','restaurant_id','email'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return User::where('email',$this->email)->first()->name ?? $this->email;
    }

}
