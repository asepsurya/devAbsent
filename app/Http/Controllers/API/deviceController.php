<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lisensi;

class deviceController extends Controller
{
    public function cekLisensi(request $request){
        $data = lisensi::where('status','Active')->get();
        foreach($data as $item){
            if($item->lisensi == $request->license){
                return response()->json([
                    'instance'=>$item->instansi,
                    'license'=> $item->lisensi,
                    'status'=>'REGISTERED',
                ]);
            }else{
                return response()->json([
                    'status'=>'UNREGISTERED',
                ]);
            }
        }

    }
}
