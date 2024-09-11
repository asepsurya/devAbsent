<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use DB;
use App\Models\rfid;
use App\Models\entyrfid;
use App\Models\absent;
use App\Models\student;
use App\Models\gtk;
use Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class rfidController extends Controller
{
    public function rfid(request $request){
        if ($request->ajax()) {
            return DataTables::of(rfid::orderBy('id', 'DESC'))->addIndexColumn()->toJson();
        }
        return view('rfid.rfid',[
            'title'=>'Registrasi RFID',
            'rfid'=>rfid::orderBy('id', 'DESC')->with(['rfidStudent','rfidGTK'])->get()
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
        $data = rfid::where('id_rfid',$request->rfid)->get();
        if($data->count()){
            foreach($data as $item){
                if($item->status == '1'){
                    return response()->json([
                        'status'=>'RFID Not Bind',
                    ]);
                }
                else{
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
                    }else{
                        // belum absen Input  jam entry
                        $status = "ENTRY";
                        absent::create([
                            'tanggal'=>date('d/m/Y'),
                            'id_rfid'=>$item->id_rfid,
                            'entry'=> $timenow,
                            'status'=>'H'
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
                        'waktu'=>date('d/m/Y ', strtotime($item->created_at)),
                        'nama'=>$nama,
                        'uid'=>$item->id_rfid,
                        'status'=>$status,

                    ]);
                }
            }
        }else{
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
    public function rfidData(){
        $data = entyrfid::orderBy('id','DESC')->get();
        foreach($data as $item){
            return $item->id_rfid;
        }

    }
    // public function rfidDataGET(request $request){
    //     return DataTables::of(rfid::query())->toJson();
    //     // $data = rfid::orderBy('id','DESC')->get();
    //     // return $data;

    // }
    public function rfidDelete($id){
        $data = rfid::where('id',$id)->get();
        foreach($data as $key){
            if($key->status == "1"){
                rfid::where('id',$id)->delete();
                toastr()->success('Data Berhasil dihapus');
                return redirect()->back();
            }else{
                toastr()->error('Data Sudah Tertaut, tidak bisa dihapus');
                return redirect()->back();

            }
        }

    }
}
