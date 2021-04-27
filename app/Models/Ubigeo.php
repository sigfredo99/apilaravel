<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = 'ubigeo';
    protected $primaryKey = 'ubigeo_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'ubigeo_id');
    }
}
