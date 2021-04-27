<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRestaurant extends Model
{
    protected $table = 'user_restaurants';
    protected $primaryKey = 'user_restaurant_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
