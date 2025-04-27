<?php

namespace App\Http\Controllers;

use App\Models\rfid;
use App\Models\User;
use App\Models\absent;
use App\Models\rombel;
use App\Models\Setting;
use App\Models\student;
use App\Models\absentMapel;
use Illuminate\Http\Request;
use App\Models\absentsHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DeviceController extends Controller
{
    public function index(){
        return view('device.index',[
            'title'=> 'Setelan Device Scanner RFID'
        ]);
    }

    public function deviceInput(request $request){
        Setting::where('key', 'device')->update(['value' => $request->device]);
        Artisan::call('optimize:clear');
        toastr()->success('Setelan Berhasil disimpan');
        return redirect()->back();
    }

    public function rfidInputDevice1(request $request){

        student::where('nis',$request->nis)->update(['id_rfid'=>$request->key]);
        $cek = rfid::where('id_rfid',$request->key)->get();
        if($cek->count()){
            rfid::where('id_rfid',$request->key)->update(['status'=>'2']);
        }else{
            rfid::create([
                'id_rfid' => $request->key,
                'status' => 2,
            ]);
        }

        // Method ubah rfid ketika  RFID Berubah
        $cekrfid = absent::where('id_rfid',$request->old_rfid)->get();
        if($cekrfid->count()){
            if($cekrfid->where('id_rfid',$request->old_rfid) !== $request->key ){
                rfid::where('id_rfid',$request->old_rfid)->update(['status'=>'1']);
                absent::where('id_rfid',$request->old_rfid)->update(['id_rfid'=>$request->key]);
                absentsHistory::where('uid',$request->old_rfid)->update(['uid'=>$request->key]);
            }
        }

        $cek = rombel::where('nis',$request->nis)->get();
        if($cek->count()){
            rombel::where('nis',$request->nis)->update(['id_rfid'=>$request->key]);
        }
        return redirect()->back();
        toastr()->success('RFID'.$request->key.' berhasil disetel');


    }
}
