<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $table = 'command';
    protected $primaryKey = 'command_id';
    protected $hidden = ['created_at', 'updated_at', 'restaurant_id', 'order_id'];
    
    public function details()
    {
        return $this->hasMany('App\Models\CommandDetail', 'command_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
