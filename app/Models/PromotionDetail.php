<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionDetail extends Model
{
    protected $table = 'promotion_details';
    protected $primaryKey = 'promotion_detail_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function promotion()
    {
        return $this->belongsTo('App\Models\Promotion', 'promotion_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
