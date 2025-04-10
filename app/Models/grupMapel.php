<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grupMapel extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function mata_pelajaran(){
        return $this->belongsTo('App\Models\Mapel','id_mapel','id');
    }
    public function guru(){
        return $this->belongsTo('App\Models\gtk','id_gtk','nik');
    }
    public function kelas(){
        return $this->belongsTo('App\Models\Kelas','id_kelas','id');
    }
    public function absent(){
        return $this->belongsTo('App\Models\absentMapel','id_mapel','id_mapel');
    }


}
