<?php

namespace App\Http\Controllers\plugin;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Imports\UserStudentImport;
use App\Http\Controllers\Controller;
use App\Imports\MyRolesStudentImport;
use Maatwebsite\Excel\Facades\Excel;

class PluginStudentController extends Controller
{
    public function studentImport(request $request){
        try {

        } catch (\Throwable $th) {
            return redirect()->back();
        }
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // menangkap file excel
        $file = $request->file('file');
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
        // upload ke folder file_siswa di dalam folder public
        $file->move('file_siswa',$nama_file);

        // import data
        Excel::import(new UserStudentImport, public_path('/file_siswa/'.$nama_file));
        Excel::import(new StudentsImport, public_path('/file_siswa/'.$nama_file));
        Excel::import(new MyRolesStudentImport, public_path('/file_siswa/'.$nama_file));

        // notifikasi dengan session
        toastr()->success('Data Berhasil diImport');
        // alihkan halaman kembali
        return redirect()->back();

    }

    public function studentIndex(){
        $file = asset('file_siswa/340817178Data Siswa Sample.xlsx');
        $data =  Excel::load($file, function($reader) {
            $results = $reader->get();
            $results = $reader->all();
         })->get();

        return view('akdemik.datainduk.students.import',[
            'title'=>'Import Data Peserta Didik',
            'a'=> $data
        ]);
    }

    
}
