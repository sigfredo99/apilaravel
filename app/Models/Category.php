<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $hidden = ['created_at', 'updated_at', 'restaurant_id'];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
