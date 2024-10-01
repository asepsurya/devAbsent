<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function mata_pelajaran(){
        return $this->belongsTo('App\Models\Mapel','id_mapel','id');
    }
    public function guru(){
        return $this->belongsTo('App\Models\gtk','id_gtk','nik');
    }
    public function ref(){
        return $this->belongsTo('App\Models\ref_jadwal','id_mapel','ref_ID');
    }
}
