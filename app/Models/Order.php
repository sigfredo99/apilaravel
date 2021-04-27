<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $hidden = ['created_at', 'updated_at', 'customer_id', 'payment_method_id'];

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }

    public function command()
    {
        return $this->hasMany('App\Models\Command', 'order_id');
    }

    public function orderStatus()
    {
        return $this->hasMany('App\Models\OrderStatus', 'order_id');
    }

    public function sale()
    {
        return $this->hasOne('App\Models\Sale', 'order_id');
    }

    public function billingData()
    {
        return $this->hasOne('App\Models\BillingData', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
    }
}
