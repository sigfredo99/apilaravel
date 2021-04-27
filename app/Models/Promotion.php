<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'promotion_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany('App\Models\PromotionDetail', 'promotion_id');
    }
}
