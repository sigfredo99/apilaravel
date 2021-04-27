<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'customer_id');
    }

    public function opinions()
    {
        return $this->hasMany('App\Models\Opinion', 'customer_id');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite', 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sale', 'customer_id');
    }
}
