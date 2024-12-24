<?php

namespace App\Http\Controllers\setelanHari;

use App\Models\setelanHari;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class setelanHariController extends Controller
{
    public function index(){
        return view('jadwal.hariefektif',[
            'title'=>'Hari Efektif',
            'data'=>setelanHari::all()
        ]);
    }

    public function add(request $request){
        $request->validate([
            'id_hari' => 'required',
            'status' => 'required',
        ]);

        setelanHari::create([
            'id_hari'=>$request->id_hari,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function update(request $request){
        $request->validate([
            'id_hari' => 'required',
            'status' => 'required',
        ]);

        $setelanHari = setelanHari::findOrFail($request->id);
        $setelanHari->id_hari = $request->id_hari;
        $setelanHari->status = $request->status;
        $setelanHari->save();
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function delete($id){
        $setelanHari = setelanHari::findOrFail($id);
        $setelanHari->delete();
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }
}
