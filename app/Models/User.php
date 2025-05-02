<?php

namespace App\Models;
use App\Models\Comment;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function student(){
        return $this->belongsTo('App\Models\student','nomor','nis');
    }
    public function gtk(){
        return $this->belongsTo(gtk::class,'nomor','nik');
    }
    public function rombelstudent(){
        return $this->belongsTo('App\Models\rombel','nomor','nis');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);  // A user can have many comments
    }


    // Balasan langsung
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
