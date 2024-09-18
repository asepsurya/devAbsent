<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function LessonIndex(){
        return view('akdemik.pengaturan.pembelajaran',[
            'title'=>'Pembelajaran',
            'Lesson'=>Lesson::where(['status'=>'1'])->get(),
        ]);
    }

    public function SettingLessonAdd(request $request){
        Lesson::create([
            'id_mapel'=>$request->mapel,
            'id_gtk'=>$request->gtk,
            'id_rombel'=>$request->rombel,
            'id_tahun_ajar'=>$request->tahun_ajar,
            'sk'=>$request->sk,
            'tanggal_sk'=>$request->tanggal_sk,
            'jml_jam'=>$request->jml_jam,
            'status'=>$request->status,
        ]);

        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function SettingLessonUpdate(request $request){
        Lesson::where('status','1')->update([
            'id_mapel'=>$request->mapel,
            'id_gtk'=>$request->gtk,
            'id_rombel'=>$request->rombel,
            'id_tahun_ajar'=>$request->tahun_ajar,
            'sk'=>$request->sk,
            'tanggal_sk'=>$request->tanggal_sk,
            'jml_jam'=>$request->jml_jam,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil diupdate');
        return redirect()->back();
    }

    public function SettingLessonDelete($id){
        Lesson::where('id', $id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
}
