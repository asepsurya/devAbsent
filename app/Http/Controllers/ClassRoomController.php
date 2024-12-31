<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\tasks;
use App\Models\student;
use App\Models\ClassRoom;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use App\Models\ClassRoomPeople;

class ClassRoomController extends Controller
{
    public function index(){
        if(request('archive')){$archive = 'true';}else{$archive = 'false';}


            if(auth()->user()->role == "siswa") {
                // Fetching the ClassRoomPeople entry for the current student
                $classRoomPeople = ClassRoomPeople::where('nis', auth()->user()->nomor)->first();

                if ($classRoomPeople) {
                    // If the student exists in ClassRoomPeople, get the associated ClassRoom
                    $data = $classRoomPeople->getClass()->with(['user', 'mapel', 'people'])->get();
                } else {
                    // If no entry for the student, set data to an empty collection or handle as needed
                    $data = collect();
                }

            } else {
                // For other roles, fetch the classrooms with 'user', 'mapel', and 'people' relationships
                $data = ClassRoom::where(['auth' => auth()->user()->nomor, 'archive' => $archive])
                    ->with(['people', 'mapel', 'user'])
                    ->get();
            }



        return view('classroom.index',[
            'title'=> 'Ruangan Kelas Saya',
            'class'=> $data,

        ]);
    }
    public function detail($id){
        return view('classroom.detail',[
            'title'=> 'Detail',
            'myclass'=>ClassRoom::where('class_code',$id)->with('user')->get(),
            'students'=>student::where('status','1')->get(),
            'class'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel'])->get(),
            'peserta'=>ClassRoomPeople::where('id_kelas',$id)->with('peopleStudent')->get(),
            'task'=>tasks::where('id_kelas',$id)->orderBy('id', 'DESC')->with(['media','links','user','comment'])->get(),
            'score'=>StudentScore::where(['student_id'=>auth()->user()->nomor])->get()
        ],compact('id'));
    }
    public function recommend(request $request){
        // GET Mapel Recomend from Input User
        $query = $request->get('query', '');
        $mapels = Mapel::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($mapels);
    }

    public function add(request $request){
        ClassRoom::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'id_mapel'=>$request->id_mapel,
            'auth'=>$request->auth,
            'class_code'=>$request->code_class,
            'archive'=>'false',
        ]);
        toastr()->success('Kelas '.$request->name.' Berhasil dibuat');
        return redirect()->back();
    }
    public function update(request $request){
        ClassRoom::where('class_code',$request->code_class)->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'id_mapel'=>$request->id_mapel,
        ]);
        toastr()->success('Kelas '.$request->name.' Berhasil diubah');
        return redirect()->back();
    }
    public function archive($id){
        if(request('act')){
            ClassRoom::where('id',$id)->update([
                'archive'=>'false',
            ]);
            toastr()->success('Kelas Berhasil dipulihkan');
        }else{
            ClassRoom::where('id',$id)->update([
                'archive'=>'true',
            ]);
            toastr()->success('Kelas Berhasil diarsipkan');
        }
        return redirect()->back();
    }

}
