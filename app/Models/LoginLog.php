<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginLog extends Model
{   
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device_name',
        'ip_address',
        'location'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // Event Listeners
    
}
