<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $hidden = ['created_at', 'updated_at', 'category_id', 'restaurant_id'];

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite', 'product_id');
    }

    public function opinions()
    {
        return $this->hasMany('App\Models\Opinion', 'product_id');
    }

    public function promotionDetails()
    {
        return $this->hasMany('App\Models\PromotionDetail', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
