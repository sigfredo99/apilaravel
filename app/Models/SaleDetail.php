<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_details';
    protected $primaryKey = 'sale_detail_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'sale_id');
    }
}
