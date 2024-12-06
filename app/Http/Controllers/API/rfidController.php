<?php

namespace App\Http\Controllers\API;
use DB;

use Alert;
use Carbon\Carbon;
use App\Models\gtk;
use App\Models\rfid;
use App\Models\absent;
use App\Models\student;
use App\Models\entyrfid;
use Illuminate\Http\Request;
use App\Models\absentsHistory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class rfidController extends Controller
{
    public function rfid(request $request) {
        if ($request->ajax()) {
            return DataTables::of(rfid::orderBy('id', 'DESC'))->addIndexColumn()->toJson();
        }
        return view('rfid.rfid',[
            'title'=>'Registrasi RFID',
            'rfid'=>rfid::orderBy('id', 'DESC')->with(['rfidStudent','rfidGTK'])->get()
        ]);
    }
    // untuk mengirim data RFID API
    public function rfidAPI(request $request) {
        $data = rfid::orderBy('id','ASC')->get();
        return response()->json([
            'status'=>true,
            'message'=>'Data ditemukan',
            'data'=>$data
        ],200);
    }

    public function rfidadd(request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $timenow= date('H:i');
        $data = rfid::where('id_rfid',$request->rfid)->get();
        if($data->count()) {
            foreach($data as $item){
                if($item->status == '1') {
                    return response()->json([
                        'status'=>'RFID Not Bind',
                    ]);
                } else if($item->status == '3') {
                        return response()->json([
                            'status'=>'BLOCKED',
                    ]);
                } else {
                    $cek = absent::where([
                        'id_rfid'=>$request->rfid,'tanggal'=>date('d/m/Y')
                    ])->get();

                    if($cek->count()){
                         // sudah absen Input jam Out
                        $status ="EXIT";
                        absent::where('id_rfid',$request->rfid)->update([
                            'out'=>$timenow,
                            'status'=>'H'
                        ]);
                          absentsHistory::create([
                            'date'=>date('d/m/Y'),
                            'time'=>$timenow,
                            'uid'=>$item->id_rfid,
                            'status'=>$status
                        ]);



                    } else {
                        // belum absen Input  jam entry
                        $status = "ENTRY";
                        absent::create([
                            'tanggal'=>date('d/m/Y'),
                            'id_rfid'=>$item->id_rfid,
                            'entry'=> $timenow,
                            'status'=>'H'
                        ]);
                        absentsHistory::create([
                            'date'=>date('d/m/Y'),
                            'time'=>$timenow,
                            'uid'=>$item->id_rfid,
                            'status'=>$status
                        ]);
                    }

                    $ceknama = gtk::where('id_rfid',$request->rfid)->get();
                    if($ceknama->count()){
                        foreach($ceknama as $a){
                            $nama = $a->nama;
                        }
                    }
                    $cekNama2 = student::where('id_rfid',$request->rfid)->get();
                    if($cekNama2->count()){
                        foreach($cekNama2 as $a){
                            $nama = $a->nama;
                        }
                    }
                    return response()->json([
                        'waktu'=>Carbon::parse(now())->translatedFormat('d/m/Y'),
                        'nama'=>$nama,
                        'uid'=>$item->id_rfid,
                        'status'=>$status,

                    ]);
                }
            }
        } else {
            rfid::create([
                'id_rfid'=>$request->rfid,
                'status'=>'1'
            ]);

            return response()->json([
                // RFID TIDAK TERDAFTAR - INPUT RFID
                'status'=>'INVALID',
            ]);
        }
    }
    // Untuk Mengambil Data
    public function rfidData(request $request){
        $data = absentsHistory::where('uid',$request->id_rfid)->get();
        foreach($data as $item){
            if($item->gtk){
                return [
                    'nama'=>$item->gtk->nama,
                    'id' =>$item->gtk->id_rfid,
                    'foto' =>$item->gtk->gambar,
                    'jam' =>$item->time,
                    
                ];
            }else{
                return [
                    'nama'=>$item->student->nama,
                    'id' =>$item->student->id_rfid,
                    'foto' =>$item->student->foto,
                    'jam' =>$item->time,
                ];
            }

        }

    }
    
    public function rfidDataGET(request $request){

        $data = absentsHistory::where('date',date('d/m/Y'))->orderBy('id','DESC')->get();
        foreach($data as $item){
            $option = "<option value='$item->uid' selected> $item->uid</option>";
             return $option;
         }

    }

    public function rfidDelete($id){
        $data = rfid::where('id',$id)->get();
        foreach($data as $key){
            if($key->status == "1"){
                rfid::where('id',$id)->delete();
                toastr()->success('Data Berhasil dihapus');
                return redirect()->back();
            } else {
                toastr()->error('Data Sudah Tertaut, tidak bisa dihapus');
                return redirect()->back();

            }
        }

    }

    public function processRfid(request $request){


         $data = rfid::where('status','1')->orderBy('id','DESC')->get();
         foreach($data as $item){
            return $item->id_rfid;
         }
         // For demonstration, return the RFID value (or process it as needed)
        
    }
}
