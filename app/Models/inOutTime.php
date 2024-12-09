<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class inOutTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kelas', 'jam_masuk', 'jam_pulang',
    ];
}
