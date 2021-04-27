<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany('App\Models\SaleDetail', 'sale_id');
    }

    public function invoicingFile()
    {
        return $this->hasOne('App\Models\InvoicingFile', 'sale_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
