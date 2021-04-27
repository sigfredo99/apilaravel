<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicingFile extends Model
{
    protected $table = 'invoicing_file';
    protected $primaryKey = 'invoicing_file_id';
    protected $hidden = ['created_at', 'updated_at', 'sale_id'];

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'sale_id');
    }
}
