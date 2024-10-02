<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absentMapel extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function absent(){
        return $this->belongsTo('App\Models\gtk','id_rfid','id_rfid');
    }
    public function student(){
        return $this->belongsTo('App\Models\student','id_rfid','id_rfid');
    }
    public function gtk(){
        return $this->belongsTo('App\Models\gtk','id_rfid','id_rfid');
    }
}
