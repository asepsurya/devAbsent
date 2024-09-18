<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\absentsHistory;

class landingController extends Controller
{
    public function index(){
        return view('frontpage.index',[
            'absent'=>absentsHistory::where('date',date('d/m/Y'))->count()
        ]);
    }

    public function listabsents(){
        $data = absentsHistory::where('date',date('d/m/Y'))->with(['student','gtk'])->orderBy('id','DESC')->get();
        return  json_encode($data);
    }

}
