<?php

namespace App\Http\Controllers;

use App\Models\gtk;
use App\Models\Kelas;
use App\Models\rombel;
use App\Models\student;
use App\Models\absentsHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index',[
            'title'=>'Dashboard',
        ]);
    }
    public function Studentindex(){
        return view('dashboard.studentDashboard',[
            'title'=>'Dashboard',
        ]);
    }
    public function teacherDashboard(){
        return view('dashboard.teacher',[
            'title'=>'Dashboard',
        ]);
    }
    public function walikelasDashboard(){
        return view('dashboard.walikelas',[
            'title'=>'Dashboard',
        ]);
    }
    public function superadmin(){
        return view('dashboard.superadmin',[
            'title'=>'Dashboard',
            // student
            'studentCount'=>student::count(),
            'studentActive'=>student::where('status','1')->count(),
            'studentDeactive'=>student::where('status','2')->count(),
            // gtk
            'gtkCount'=>gtk::count(),
            'gtkActive'=>gtk::where('status','1')->count(),
            'gtkDeactive'=>gtk::where('status','2')->count(),
            // rombel
            'kelas'=>kelas::where('status','1')->with(['jurusanKelas','jmlRombel'])->get(),
            'rombelCount'=>rombel::count(),
            'rombelActive'=>rombel::where('status','1')->count(),
            'rombelDeactive'=>rombel::where('status','2')->count(),
            // kelas
            'kelasCount'=>Kelas::count(),
            'kelasActive'=>Kelas::where('status','1')->count(),
            'kelasDeactive'=>Kelas::where('status','2')->count(),
            // absen
            'absenEntryCount'=>AbsentsHistory::where('status', 'ENTRY')->whereDate('created_at', Carbon::today())->count(),
            'absenOutCount'=>absentsHistory::where('status', 'EXIT')->whereDate('created_at', Carbon::today())->count(),
        ]);
    }
}
