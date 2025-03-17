<?php

namespace App\Http\Controllers\plugin;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\tasks;
use App\Models\student;
use App\Models\ClassRoom;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use App\Models\ClassRoomPeople;
use App\Http\Controllers\Controller;

class ClassRoomController extends Controller
{
    public function index(){
        if(request('archive')){$archive = 'true';}else{$archive = 'false';}


            if(auth()->user()->role == "siswa") {
                 // Get all ClassRoomPeople entries for the current student (not just the first one)
                $classRoomPeople = ClassRoomPeople::where('nis', auth()->user()->nomor)->get();

                // If there are matching entries for the student
                if ($classRoomPeople->isNotEmpty()) {
                    // Retrieve the associated classrooms for all the records
                    $data = $classRoomPeople->flatMap(function ($classRoomPeopleEntry) {
                        return $classRoomPeopleEntry->getClass()->with(['user', 'mapel', 'people'])->get();
                    });
                } else {
                    // If no entries for the student, set data to an empty collection
                    $data = collect(); // Or handle as necessary (e.g., return an error message)
                }

             }

             else if (auth()->user()->role == "superadmin" || auth()->user()->role == "admin" ) {
                // For other roles, fetch the classrooms with 'user', 'mapel', and 'people' relationships
                $data = ClassRoom::where(['archive' => $archive])
                    ->with(['people', 'mapel', 'user'])
                    ->get();
            }
            else {
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
            'myclass'=>ClassRoom::where('class_code',$id)->with(['gtk','user'])->get(),
            'students'=>student::where('status','1')->get(),
            'class'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel'])->get(),
            'peserta'=>ClassRoomPeople::where('id_kelas',$id)->with(['getScore','peopleStudent'])->get(),
            'task'=>tasks::where('id_kelas',$id)->orderBy('id', 'DESC')->with(['media','links','user','user.gtk','comment'])->get(),
            'duedate'=>tasks::upcomingTasks()->where('id_kelas',$id)->orderBy('due_date')->get(),
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
