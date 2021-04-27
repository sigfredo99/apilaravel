<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $table = 'opinions';
    protected $primaryKey = 'opinion_id';
    protected $hidden = ['created_at', 'updated_at', 'customer_id', 'product_id'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
