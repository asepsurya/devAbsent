<?php

namespace App\Http\Controllers;
use App\Models\Mapel;
use App\Models\TahunPelajaran;
use App\Models\Kelas;
use App\Models\grupMapel;
use Illuminate\Http\Request;

class pengaturanAkademik extends Controller
{
    public function pengaturanMapel(){
        return view('akdemik.pengaturan.matapelajaran',[
            'title'=>'Pengaturan Mata Pelajaran',
            'mapel'=>Mapel::where('status','1')->get(),
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->get(),
            'grupMapel'=>grupMapel::orderBy('id', 'DESC')->get(),
        ]); 
    }
    public function pengaturanMapelAdd(request $request){
      
        grupMapel::create([
            'id_mapel'=>$request->id_mapel,
            'status'=>'1'
        ]);
        return redirect()->back();
    }
    public function pengaturanMapelUpdate(request $request){
        
        grupMapel::where('status','1')->update([
            'id_tahun_pelajaran'=>$request->tahunAjar,
            'id_kelas'=>$request->kelas,
            'status'=>'2',
        ]);
         toastr()->success('Data Berhasil disubmit');
        return redirect()->back();
    }
    public function pengaturanMapelDelete($id){
        grupMapel::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
}
