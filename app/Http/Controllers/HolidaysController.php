<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HolidaysController extends Controller
{
    public function index(){
        return view('holidays.index',[
            'title' => 'Hari Libur',
            'holidays'=>Event::all()
        ]);
    }
}
