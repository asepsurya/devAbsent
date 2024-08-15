<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gtk extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function Usergtk(){
        return $this->belongsTo('App\Models\user','nik','nomor');
    }
}
