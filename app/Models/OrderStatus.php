<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
