<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $guarded=['id'];
    public function user(){
        return $this->belongsTo('App\Models\user','auth','nomor');
    }
    public function mapel(){
        return $this->belongsTo('App\Models\Mapel','id_mapel','id');
    }
}
