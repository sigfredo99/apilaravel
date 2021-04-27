<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'order_detail_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
