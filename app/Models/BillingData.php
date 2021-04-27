<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingData extends Model
{
    protected $table = 'billing_data';
    protected $primaryKey = 'billing_data_id';
    protected $hidden = ['created_at', 'updated_at', 'order_id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
