<?php

namespace App\Http\Controllers;
use DB;
use App\Models\rfid;
use App\Models\entyrfid;
use App\Models\absent;
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
        date_default_timezone_set('Asia/Jakarta');
        $timenow= date('H:i');
        $data = rfid::where('id_rfid',$request->id_rfid)->get();
        if($data->count()){
            foreach($data as $item){
                if($item->status == '1'){
                    return response()->json([
                        'status'=>'RFID Not Bind',
                    ]);
                }else{
                    $cek = absent::where([
                        'id_rfid'=>$request->id_rfid,'tanggal'=>date('d/m/y')
                    ])->get();
                    if($cek->count()){
                         // sudah absen Input jam Out
                        $status ="EXIT";
                        absent::where('id_rfid',$request->id_rfid)->update([
                            'out'=>$timenow
                        ]);
                    }else{
                        absent::create([
                            'tanggal'=>date('d/m/y'),
                            'id_rfid'=>$item->id_rfid,
                            'entry'=> $timenow
                        ]);
                        // belum absen Input  jam entry
                        $status = "ENTRY";
                    }
                    return response()->json([
                        'waktu'=>date('d/m/Y ', strtotime($item->created_at)),
                        'nama'=>$item->rfidStudent->nama,
                        'uid'=>$item->id_rfid,
                        'status'=>$status,
                    ]);
                }
            }
        }else{
            rfid::create([
                'id_rfid'=>$request->id_rfid,
                'status'=>'1'
            ]);
            return response()->json([
                // RFID TIDAK TERDAFTAR - INPUT RFID
                'status'=>'INVALID',
            ]);
        }
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
