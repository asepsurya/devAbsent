<?php

namespace App\Http\Controllers;
use Alert;
use Validator;
use App\Models\gtk;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Lesson;
use App\Models\rombel;
use App\Models\student;
use App\Models\grupMapel;
use App\Models\walikelas;
use App\Imports\MapelImport;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class pengaturanAkademik extends Controller
{
    public function pengaturanMapel(request $request){

        if ($request->ajax()) {
            return DataTables::of(Mapel::orderBy('nama', 'ASC'))->addIndexColumn()->toJson();
        }

        if(request()){
            $data =  grupMapel::where([
                'id_tahun_pelajaran'=> request('id_tahun_pelajaran'),
                'id_kelas'=>request('id_kelas'),
                'status'=>'2'
                ])->with('mata_pelajaran')->paginate(15)->appends(request()->query());
         }
        return view('akdemik.pengaturan.matapelajaran',[
            'title'=>'Mata Pelajaran',
            'mapel'=>Mapel::where('status','1')->get(),
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'grupMapel'=>$data,
            'mapelnotAllow'=>grupMapel::where(['status'=>'1'])->get()
        ]);
    }

    public function PengaturanWalikelas(){
        return view('akdemik.pengaturan.walikelas',[
            'title'=> 'Wali Kelas',
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with(['jurusanKelas','jmlRombel'])->get(),
            'gtk'=>gtk::where('status','1')->get(),
            'walikelas'=>walikelas::orderBy('id', 'DESC')->with(['gtk','tahun_ajar'])->get(),
        ]);
    }

    public function pengaturanWalikelasAdd(request $request){
        walikelas::create([
            'id_tahun_pelajaran'=>$request->tahun,
            'id_kelas'=>$request->kelas,
            'id_gtk'=>$request->id_gtk
        ]);

          User::where('nomor',$request->id_gtk)->update(['role'=>'walikelas']);
          $cekid = User::where('nomor',$request->id_gtk)->get();
          foreach($cekid as $key){
              $getid = $key->id;
              DB::table('model_has_roles')->where('model_id','=', $getid)->update(array('role_id'=>'1'));
          }
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function pengaturanWalikelasEdit(request $request){
        // ubah dulu role ke guru
        User::where('nomor',$request->id_gtk_default)->update(['role'=>'guru']);
          $cekid = User::where('nomor',$request->id_gtk_default)->get();
          foreach($cekid as $key){
              $getid = $key->id;
              DB::table('model_has_roles')->where('model_id','=', $getid)->update(array('role_id'=>'2'));
          }
        //  update ke walikelas
        walikelas::where('id',$request->id)->update([
            'id_tahun_pelajaran'=>$request->tahun,
            'id_kelas'=>$request->kelas,
            'id_gtk'=>$request->id_gtk
        ]);

          User::where('nomor',$request->id_gtk)->update(['role'=>'walikelas']);
          $cekid = User::where('nomor',$request->id_gtk)->get();
          foreach($cekid as $key){
              $getid = $key->id;
              DB::table('model_has_roles')->where('model_id','=', $getid)->update(array('role_id'=>'1'));
          }
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function dataTujuanSiswa(request $request){
        $searchTerm = $request->get('search'); // Get the search term from the request
        $tahunAjar = $request->get('id_tahun_pelajaran');
        $kelasTujuan = $request->get('id_kelas_tujuan');
    
        // Filter the data based on the search term
        $query = rombel::where('id_tahun_pelajaran', $tahunAjar)
                        ->where('id_kelas', $kelasTujuan)->with('rombelStudent');
    
         if ($searchTerm) {
            $query->where(function($query) use ($searchTerm) {
                $query->where('nis', 'like', "%{$searchTerm}%")
                    ->orWhereHas('rombelStudent', function($query) use ($searchTerm) {
                        $query->where('nama', 'like', "%{$searchTerm}%");
                    });
            });
        }
        
        $students = $query->get(); // Adjust pagination as needed
      
        return DataTables::of($students) 
        ->addColumn('nama', function (rombel $item) { 
            return $item->rombelStudent->nama; // Access the 'nama' from the related model
             })->addIndexColumn() ->make(true);
            
    }

    public function dataAwalSiswa(request $request){
        if ($request->ajax()) {
            // Checking the value of 'id_kelas_asal' and querying data accordingly
            if ($request->input('id_kelas_asal') == "all") {
                // Get all students with status 1
                $data = Student::where('status', '1')->get();
            } elseif ($request->input('id_kelas_asal') == "belumDiatur") {
                // Get students who do not have a class assigned (id_kelas is NULL)
                $data = Student::whereNull('id_kelas')->where('status', '1')->get();
            } else {
                // Get students from the specific rombel and tahun ajar
                $data = Rombel::where('id_kelas', $request->input('id_kelas_asal'))
                    ->where('id_tahun_pelajaran', $request->input('tahunAjarAsal'))
                    ->get();
            }
    
            // Return data as DataTables response
            return DataTables::of($data)
                ->addColumn('nama', function ($item) use ($request) {
                    // Conditional logic for 'nama' field depending on 'id_kelas_asal'
                    if ($request->input('id_kelas_asal') == "belumDiatur" || $request->input('id_kelas_asal') == "all") {
                        return $item->nama; // Return the student's name directly
                    } else {
                        // Assuming 'rombelStudent' is a relation on the Student model
                        return $item->rombelStudent->nama; // Return the name from the related 'rombelStudent'
                    }
                })
                ->addIndexColumn() // Add an index column
                ->make(true); // Return the DataTable JSON response
        }  

    }

    public function PengaturaRombel(request $request){



        // jika ada request atau filter 1
        if(request('id_kelas_asal') =="all"){
            $data = student::where(['status'=>'1'])->paginate(10)->appends(request()->query());

        }elseif(request('id_kelas_asal') == "belumDiatur"){
            $data = student::where(['id_kelas'=>NULL,'status'=>'1'])->paginate(10)->appends(request()->query());
        }
        else{
            $data = rombel::where(['id_kelas'=>request('id_kelas_asal'),'id_tahun_pelajaran'=>request('tahunAjarAsal')])->paginate(10)->appends(request()->query());
        }
        // filter Tujuan Kelas
        if(request() ){
            $mydata = rombel::where(['id_kelas'=>request('id_kelas_tujuan'),'id_tahun_pelajaran'=>request('id_tahun_pelajaran')])->with('rombelStudent')->paginate(10)->appends(request()->query());
        }
        return view('akdemik.pengaturan.rombel',[
            'title'=>'Rombongan Belajar',
            'students'=>$data,
            'studentsClass'=>$mydata,
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
        ]);
    }

    public function PengaturaRombelUpdate(request $request){
            // Validate that the input is an array
    $request->validate([
        'nis' => 'required|array', // Ensure nis is an array
        'nis.*' => 'required|string', // Each nis must be a string

    ]);

    // Loop through each nis (student)
    foreach ($request->nis as $key => $nis) {
        // Check if the student is already in the class
        $cek = rombel::where('nis', $nis)->get();

        if ($cek->count() != 0) {
            // Loop through each record found
            foreach ($cek as $item) {
                // If the student is already in the same class
                if ($item->id_kelas == $request->id_kelas) {
                    toastr()->warning('Sudah terdaftar dikelas ini untuk NIS ' . $nis);
                    return redirect()->back()->withInput();
                } else {
                    // If the class or year is missing, show an error
                    if ($request->id_tahun_pelajaran == "" || $request->id_kelas == '') {
                        toastr()->error('Mohon Periksa Kembali Kelas Tujuan untuk NIS ' . $nis);
                        return redirect()->back()->withInput();
                    } else {
                        // Update the rombel and student records
                        rombel::where('nis', $nis)->update([
                            'id_kelas' => $request->id_kelas,
                            'id_tahun_pelajaran' => $request->id_tahun_pelajaran,
                        ]);
                        student::where('nis', $nis)->update([
                            'id_kelas' => $request->id_kelas,
                        ]);
                        toastr()->success('Data untuk NIS ' . $nis . ' berhasil dipindahkan');
                    }
                }
            }
        } else {
            // If the student is not found, create a new record
            if ($request->id_kelas == "" || $request->id_tahun_pelajaran == "") {
                toastr()->error('Mohon Periksa Kembali Kelas Tujuan untuk NIS ' . $nis);
                return redirect()->back()->withInput();
            } else {
                // Create a new rombel record for the student
                rombel::create([
                    'nis' => $nis,
                    'id_kelas' => $request->id_kelas,
                    'id_tahun_pelajaran' => $request->id_tahun_pelajaran,
                    'status' => '1',
                    'id_rfid'=>$request->id_rfid[$key]
                ]);

                student::where('nis', $nis)->update([
                    'id_kelas' => $request->id_kelas,
                ]);

                toastr()->success('Data untuk NIS ' . $nis . ' berhasil disubmit');
            }
        }
    }

    // Redirect back with success message
    // toastr()->success('Data Berhasil disubmit');
    return redirect(route('PengaturaRombel','id_kelas_asal='.$request->id_kelas_asal.'&tahunAjarAsal='.$request->tahunAjarAsal.'&id_kelas_tujuan='.$request->id_kelas.'&id_tahun_pelajaran='.$request->id_tahun_pelajaran))->withInput();

    }

    public function subject_teachers(){
        if(request()){
            $data =  grupMapel::where(['id_tahun_pelajaran'=> request('tahun'),'id_kelas'=>request('kelas')])->with('mata_pelajaran')->get();
         }
       return view('akdemik.pengaturan.gurumapel',[
        'title'=> 'Guru Mata Pelajaran',
        'mapel'=>Mapel::where('status','1')->get(),
        'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
        'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
        'gtk'=>gtk::where('status','1')->get(),
        'grupMapel'=>$data,
       ]);
    }
    public function pengaturanMapelAdd(request $request){

     // Example logic: Insert selected mapel into the database
     $selectedIds = $request->selectedIds;

     // Check if selectedIds is not empty and handle accordingly
     if (!empty($selectedIds)) {
         // Assuming you are saving the selected mapel to a table like grup_mapel
         foreach ($selectedIds as $id) {
             grupMapel::create([
                 'id_mapel' => $id,
                 'status' => '1',  // Assuming '1' means active or selected
             ]);
         }

         // Return a success message
         return response()->json([
             'message' => 'Selected data has been saved successfully.',
         ]);
     }

     // Return an error message if no IDs were selected
     return response()->json([
         'message' => 'Please select at least one mapel.',
     ]);

    }
    public function pengaturanMapelUpdate(request $request){

        grupMapel::where('status','1')->update([
            'id_tahun_pelajaran'=>$request->tahun,
            'id_kelas'=>$request->kelas,
            'semester'=>$request->semester,
            'status'=>'2',
            'id_gtk'=>''
        ]);
        toastr()->success('Data Berhasil disubmit');
        return redirect()->back();
    }
    public function pengaturanMapelDelete($id){
        grupMapel::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }

    public function pengaturanMapelImport(request $request){
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // menangkap file excel
        $file = $request->file('file');
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
                 // upload ke folder file_siswa di dalam folder public
        $file->move('file_mapel',$nama_file);
             // import data
        Excel::import(new MapelImport, public_path('/file_mapel/'.$nama_file));
        // notifikasi dengan session
        toastr()->success('Data Berhasil diImport');
        // alihkan halaman kembali
        return redirect()->back();
    }

    public function subject_teachersUpdate(request $request){
        // Retrieve input data from the form submission
        $idtahun = $request->input('tahun');
        $idkelas = $request->input('id_kelas');
        $semester = $request->input('semester');
        $idmapel = $request->input('id'); // Array of subject IDs
        $idgtk = $request->input('id_gtk'); // Array of teacher IDs

        // Ensure arrays are not empty
        if (count($idmapel) != count($idgtk)) {
            return redirect()->back()->withErrors(['msg' => 'The number of subjects does not match the number of teachers.']);
        }

        // Loop through each subject to update the respective GTK
        foreach ($idmapel as $index => $mapelId) {
            // Find the lesson by the subject ID, class ID, and year
            $lesson = grupMapel::where([
                'id_mapel' => $mapelId,
                'id_kelas' => $idkelas,
                'id_tahun_pelajaran' => $idtahun,
            ])->first();

            // If the lesson exists, update the GTK
            if ($lesson) {
                // Update the GTK for the current subject
                $lesson->update([
                    'id_gtk' => $idgtk[$index] ?? null,  // Use null if no GTK ID is provided
                ]);
                $cekJadwal = Lesson::where('id_mapel',$mapelId)->first();
                if($cekJadwal){
                    $cekJadwal->update(['id_gtk' => $idgtk[$index] ?? null, ]);
                }
            }
        }
        // After updating, show a success message and redirect back
        toastr()->success('Data successfully updated');
        return redirect()->back();

    }
}
