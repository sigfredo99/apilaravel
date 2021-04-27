<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'address_id';
    protected $hidden = ['created_at', 'updated_at', 'customer_id', 'ubigeo_id'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function ubigeo()
    {
        return $this->belongsTo('App\Models\Ubigeo', 'ubigeo_id');
    }
}
