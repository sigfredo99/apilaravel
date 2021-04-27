<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandDetail extends Model
{
    protected $table = 'command_details';
    protected $primaryKey = 'command_detail_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function command()
    {
        return $this->belongsTo('App\Models\Command', 'command_id');
    }
}
