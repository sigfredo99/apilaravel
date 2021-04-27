<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function userRestaurants()
    {
        return $this->hasMany('App\Models\UserRestaurant', 'user_id');
    }
}
