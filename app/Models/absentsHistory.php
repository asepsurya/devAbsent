<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absentsHistory extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function student(){
        return $this->belongsTo('App\Models\student','uid','id_rfid');
    }
    public function gtk(){
        return $this->belongsTo('App\Models\gtk','uid','id_rfid');
    }
}
