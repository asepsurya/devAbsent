<?php

namespace App\Http\Controllers;

use App\Models\rfid;
use App\Models\Setting;
use App\Models\student;
use Illuminate\Http\Request;
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
         // Check if RFID key already exists
        $exists =  student::where('id_rfid',$request->key)->exists();

        if ($exists) {
            toastr()->warning('UID :'.$request->key.' already exists!');
            return redirect()->back();
        }

        rfid::create([
            'id_rfid' => $request->key,
            'status' => 2,
        ]);
        student::where('nis',$request->nis)->update([
            'id_rfid' => $request->key,
        ]);
        toastr()->success('RFID'.$request->key.' berhasil disetel');


    }
}
