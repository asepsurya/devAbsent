<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'description',
        'id_kelas',
        'created_by',
        'poin',
        'due_date',
        'type',
    ];

    public function media(){
        return $this->Hasmany('App\Models\tasksmedia','task_id','id');
    }
    public function links(){
        return $this->belongsTo('App\Models\taskslink','id','task_id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','created_by','nomor');
    }
    public function getKelas(){
        return $this->belongsTo('App\Models\ClassRoom','id_kelas','class_code');
    }

    public function getPeople(){
        return $this->Hasmany('App\Models\ClassRoomPeople','id_kelas','id_kelas');
    }
    public function comment(){
        return $this->Hasmany('App\Models\Comment','task_id','id');
    }
    public function getFileTugas(){
        return $this->Hasmany('App\Models\fileTugas','task_id','id');
    }

    public function scopeUpcomingTasks($query)
    {
        $today = Carbon::now()->startOfDay()->format('d-m-Y');
        $threeDaysAhead = Carbon::now()->addDays(3)->endOfDay()->format('d-m-Y');

        return $query->whereBetween('due_date', [$today, $threeDaysAhead])
                     ->where('type', 'task');

    }


}
