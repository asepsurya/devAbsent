<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absent extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function absent(){
        return $this->belongsTo('App\Models\gtk','id_rfid','id_rfid');
    }

}
