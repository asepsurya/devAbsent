<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
