<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';
    public $timestamps = false;

    protected $primaryKey = 'email'; // kalau mau pakai email sebagai primary key
    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
