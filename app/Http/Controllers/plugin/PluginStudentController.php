<?php

namespace App\Http\Controllers\plugin;

use App\Imports\GtkImport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Imports\MyRolesGTKImport;
use App\Imports\UserStudentImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MyRolesStudentImport;

class PluginStudentController extends Controller
{
    public function dataImport(){
        return view('plugin.import_student_gtk.index',[
            'title'=> 'Management Import Data'
        ]);
    }
    
    public function studentImport(request $request){

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // menangkap file excel
        $file = $request->file('file');
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
        // upload ke folder file_siswa di dalam folder public

        if($request->data_location == 'student'){
            $file->move('file_siswa',$nama_file);
            // import data
            Excel::import(new UserStudentImport, public_path('/file_siswa/'.$nama_file));
            Excel::import(new StudentsImport, public_path('/file_siswa/'.$nama_file));
            Excel::import(new MyRolesStudentImport, public_path('/file_siswa/'.$nama_file));
        }else{
            $file->move('file_gtk',$nama_file);
            // import data
            Excel::import(new UserImport, public_path('/file_gtk/'.$nama_file));
            Excel::import(new GtkImport, public_path('/file_gtk/'.$nama_file));
            Excel::import(new MyRolesGTKImport, public_path('/file_gtk/'.$nama_file));
        }
        // notifikasi dengan session
        toastr()->success('Data Berhasil diImport');
        // alihkan halaman kembali
        return redirect()->back();

    }
    
   


}
