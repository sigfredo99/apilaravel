<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';
    protected $primaryKey = 'restaurant_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'restaurant_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'restaurant_id');
    }

    public function command()
    {
        return $this->hasMany('App\Models\Command', 'restaurant_id');
    }

    public function promotionDetails()
    {
        return $this->hasMany('App\Models\PromotionDetail', 'restaurant_id');
    }

    public function userRestaurants()
    {
        return $this->hasMany('App\Models\UserRestaurant', 'restaurant_id');
    }
}
