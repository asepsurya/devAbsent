<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rfid extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function rfidStudent(){
        return $this->belongsTo('App\Models\student','id_rfid','id_rfid');
    }
    public function rfidGTK(){
        return $this->belongsTo('App\Models\gtk','id_rfid','id_rfid');
    }
}

