<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $primaryKey = 'payment_method_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'payment_method_id');
    }
}
