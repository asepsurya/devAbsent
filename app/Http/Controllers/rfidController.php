<?php

namespace App\Http\Controllers;
use DB;
use App\Models\rfid;
use App\Models\entyrfid;
use Illuminate\Http\Request;

class rfidController extends Controller
{
    public function rfid(){
        return view('rfid.rfid',[
            'title'=>'Registrasi RFID',
        ]);
    }
    // untuk mengirim data RFID API
    public function rfidAPI(request $request){
        $data = rfid::orderBy('id','ASC')->get();
        return response()->json([
            'status'=>true,
            'message'=>'Data ditemukan',
            'data'=>$data
        ],200);
    }

    public function rfidadd(request $request){
       DB::delete("delete from entyrfids ");
        rfid::create([
            'id_rfid'=>$request->id_rfid,
            'status'=>'1'
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }
    // Untuk Mengambil Data
    public function rfidData(){
        $data = entyrfid::orderBy('id','DESC')->get();
        foreach($data as $item){
            return $item->id_rfid;
        }

    }
    public function rfidDataGET(request $request){
        $data = rfid::orderBy('id','DESC')->get();
        return $data;

    }
}
