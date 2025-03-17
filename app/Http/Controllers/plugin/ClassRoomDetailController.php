<?php

namespace App\Http\Controllers\plugin;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\tasks;
use App\Models\Comment;
use App\Models\student;
use App\Models\question;
use App\Models\ClassRoom;
use App\Models\fileTugas;
use App\Models\taskslink;
use App\Models\tasksmedia;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use App\Models\studentAnswer;
use App\Models\ClassRoomPeople;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\View\Components\Task;

class ClassRoomDetailController extends Controller
{

    // kelas
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



        return view('plugin.classroom.index',[
            'title'=> 'Ruangan Kelas Saya',
            'class'=> $data,

        ]);
    }
    public function detail($id){
        return view('plugin.classroom.detail',[
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

    // for Detail Class

    public function adduser(request $request){
                // Get the class id from the hidden input
        $id_kelas = $request->input('id_kelas');

        // Get the selected nis values from the checkbox inputs
        $nisArray = $request->input('nis');

        // Initialize a variable to collect warning messages
        $warningMessages = [];

        // Check if nisArray is not empty
        if (!empty($nisArray)) {
            // Loop through the nisArray and insert each selected student into the ClassRoomPeople table
            foreach ($nisArray as $nis) {
                // Check if the combination of id_kelas and nis already exists
                $existingRecord = ClassRoomPeople::where('id_kelas', $id_kelas)
                                                ->where('nis', $nis)
                                                ->first();
                // If the record doesn't exist, create a new entry
                if (!$existingRecord) {
                    ClassRoomPeople::create([
                        'id_kelas' => $id_kelas,
                        'nis' => $nis,
                    ]);
                } else {
                    // Add a warning message if the student is already registered in the class
                    $warningMessages[] = 'Siswa dengan NIS ' . $nis . ' sudah terdaftar di kelas ini.';
                }
            }

            // Show warning messages only once if there are any
            if (count($warningMessages) > 0) {
                toastr()->warning(implode('<br>', $warningMessages));
            } else {
                toastr()->success('Students added to the classroom.');
            }

            // Redirect or return a success response
            return redirect()->back();
        } else {
            // Handle the case where no students were selected
            toastr()->error('No students selected.');
            return redirect()->back();
        }

    }

    public function adduserClass(request $request){
        $id_kelasArray = $request->input('id_kelas'); // Array of id_kelas

        if (!empty($id_kelasArray)) {
            $studentsAdded = 0;
            $alreadyExists = []; // To track NIS already in the table

            foreach ($id_kelasArray as $idKelas) {
                // Fetch all students for the given id_kelas
                $students = student::where('id_kelas', $idKelas)->get();

                foreach ($students as $student) {
                    $nis = $student->nis;

                    // Check if this combination of id_kelas and nis already exists in ClassRoomPeople
                    $exists = ClassRoomPeople::where('id_kelas', $request->class_code)
                                             ->where('nis', $nis)
                                             ->exists();

                    if (!$exists) {
                        // Insert the student if not already present
                        ClassRoomPeople::create([
                            'id_kelas' => $request->class_code,
                            'nis' => $nis,
                        ]);
                        $studentsAdded++;
                    } else {
                        // Track NIS already existing
                        $alreadyExists[] = $nis;
                    }
                }
            }

            // Success and warnings
            if ($studentsAdded > 0) {
                toastr()->success("$studentsAdded students added to the classroom.");
            }
            if (!empty($alreadyExists)) {
                $existingNISList = implode(', ', $alreadyExists);
                toastr()->warning("The following NIS already exist in the class: $existingNISList.");
            }

            return redirect()->back();
        } else {
            toastr()->error('No classrooms selected.');
            return redirect()->back();
        }

    }

    public function deleteuserClass($id){
        ClassRoomPeople::where('nis',$id)->delete();
        toastr()->success('data berhasil dihapus');
        return redirect()->back();
    }

    public function tugas($id){
        return view('plugin.classroom.work.tugas',[
            'title'=>'Tugas'
        ],compact('id'));
    }
    public function deletequizAction(request $request){
        // Find the task by ID (or return 404 if not found)
        $task = tasks::findOrFail($request->task_id);

        // Validate the input data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_kelas' => 'string',
            'poin' => 'nullable|integer',
            'due_date' => 'nullable|date',
            'dok.*' => 'nullable|file|max:2048', // Max 2MB per file
            'link.*' => 'nullable',
        ]);
        $task->update([
            'judul' => $validated['judul'],
            'description' => $validated['description'],
            'id_kelas' => $validated['id_kelas'],
            'poin' => $validated['poin'],
            'due_date' => $validated['due_date'],
            'type' => $request->type,  // Assuming 'type' is passed in the request
        ]);
        toastr()->success('data berhasil dihapus');
        return redirect()->back();
    }
    public function tambahTugas(request $request){
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_kelas' => 'string',
            'poin' => 'nullable|integer',
            'due_date' => 'nullable|date',
            'dok.*' => 'nullable|file|max:2048', // Max 2MB per file
        ]);

        // Save task details
        $task = tasks::create([
            'judul' => $validated['judul'],
            'description' => $validated['description'],
            'id_kelas' => $validated['id_kelas'],
            'created_by' => auth()->user()->nomor,
            'poin' => $validated['poin'],
            'due_date' => $validated['due_date'],
            'type'=>$request->type
        ]);

        if ($request->hasFile('dok')) {
            foreach ($request->file('dok') as $file) {
                // Retrieve file name and size
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize(); // File size in bytes
                $fileExstention =$file->getClientOriginalExtension();

                // Store the file in the public/uploads/tasks directory
                $path = $file->store('uploads/tasks', 'local');

                // Save the file information to the database
                tasksmedia::create([
                    'task_id' => $task->id, // Use the actual task ID
                    'file_path' => $path,
                    'name' => $fileName, // Save the original file name
                    'size' => $fileSize, // Save the file size
                    'exstention'=>$fileExstention
                ]);
            }
        }
        if($request->link){
            // Process each link
                taskslink::create([
                    'task_id' => $task->id,  // Assuming $task is defined
                    'youtube_link' => $request->link,
                ]);

        }

        toastr()->success('data berhasil dihapus');
        return redirect()->route('classroom.detail',$request->id_kelas);
    }

    public function editTugasAction(request $request){
         // Validate the incoming request data
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'description' => 'nullable|string',
                'id_kelas' => 'string',
                'poin' => 'nullable|integer',
                'due_date' => 'nullable|date',
                'dok.*' => 'nullable|file|max:2048', // Max 2MB per file

            ]);

            // Find the task to update
            $task = tasks::findOrFail($request->task_id); // Ensure task exists, if not it will throw a 404 error

            // Update task details
            $task->update([
                'judul' => $validated['judul'],
                'description' => $validated['description'],
                'id_kelas' => $validated['id_kelas'],
                'poin' => $validated['poin'],
                'due_date' => $validated['due_date'],
                'type' => $request->type, // Assuming 'type' is sent in the request
            ]);

            // Handle file uploads
            if ($request->hasFile('dok')) {
                foreach ($request->file('dok') as $file) {
                    // Retrieve file name and size
                    $fileName = $file->getClientOriginalName();
                    $fileSize = $file->getSize(); // File size in bytes
                    $fileExstention = $file->getClientOriginalExtension();

                    // Store the file in the public/uploads/tasks directory
                    $path = $file->store('uploads/tasks', 'local');

                    // Save the file information to the database
                    tasksmedia::create([
                        'task_id' => $task->id, // Use the actual task ID
                        'file_path' => $path,
                        'name' => $fileName, // Save the original file name
                        'size' => $fileSize, // Save the file size
                        'exstention' => $fileExstention
                    ]);
                }
            }

            // Handle YouTube link updates (if provided)
            if ($request->link) {
                $data = taskslink::where('task_id', $task->id)->first();

                if ($data) {
                    // If the record exists, update it
                    $data->update([
                        'youtube_link' => $request->link // Update the youtube_link
                    ]);
                } else {
                    // If the record doesn't exist, create a new one
                    taskslink::create([
                        'task_id' => $task->id,
                        'youtube_link' => $request->link // Create with the provided youtube_link
                    ]);
                }


            }

            // Send success message
            toastr()->success('Task updated successfully');

            // Redirect to the classroom detail page
            return redirect()->route('classroom.detail', $request->id_kelas);
    }

     // Define a method to extract YouTube video ID
     public function extractYouTubeVideoId($url)
     {
         // Regular expression to extract the video ID
         $pattern = '/(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/]+\/.*\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=))([^"&?\/\s]{11})/';

         preg_match($pattern, $url, $matches);

         // Return the video ID or null if no match is found
         return $matches[1] ?? null;
     }

    public function editTugas($task_id){
       // Find the task based on the provided task_id
        $task = tasks::find($task_id);

        // Retrieve all task media files related to the task
        $taskFiles = tasksmedia::where('task_id', $task_id)->get();

        // Retrieve all YouTube links associated with the task
        $taskLinks = taskslink::where('task_id', $task_id)->get();

        // Initialize the videoIds array
        $videoIds = [];

        // Iterate over each taskLink and extract video IDs
        foreach($taskLinks as $i) {
            $urls = explode(',', $i->youtube_link);  // Assuming URLs are separated by commas

            // Extract video IDs from all URLs for each taskLink
            $currentVideoIds = array_map([$this, 'extractYouTubeVideoId'], $urls);

            // Merge the current video IDs with the main array (to avoid overwriting previous ones)
            $videoIds = array_merge($videoIds, $currentVideoIds);
        }

        // If no video IDs were found, ensure that $videoIds is an empty array
        $videoIds = !empty($videoIds) ? $videoIds : [];
        $urls = !empty($urls) ? $urls : [];

        // Pass all the data to the view
        return view('plugin.classroom.work.tugasEdit', [
            'title' => 'Edit Tugas ',
        ], compact('task', 'taskFiles', 'taskLinks', 'videoIds', 'urls','task_id'));  // Ensure the correct variable name is used

    }

    public function deleteTaskAction($task_id){
         // First, delete all associated task media (files) for this task
        tasksmedia::where('task_id', $task_id)->delete();

        // Then, delete all associated task links (e.g., YouTube links)
        taskslink::where('task_id', $task_id)->delete();

        // Finally, delete the actual task itself
        tasks::where('id', $task_id)->delete();

        // Optionally, you can redirect or show a success message
        toastr()->success('Task and associated data deleted successfully');
        return redirect()->back();// Or wherever you want to redirect
    }



    public function tambahQuiz($id_kelas , $task_id){
        return view('plugin.classroom.work.quiz.quizAdd',[
            'title'=>'Quiz'
        ],compact('id_kelas','task_id'));
    }

    public function quiz($id_kelas , $task_id){
        $task = tasks::where('id', $task_id)->first();
        $name = $task ? $task->judul : null;

        $userId = auth()->user()->nomor; // Pastikan ini sesuai dengan database
        return view('plugin.classroom.work.quiz.quizList', [
            'title' => 'My Quiz',
            'name_task' => $name,
            'quest' => question::where('task_id', $task_id)->orderBy('id', 'DESC')->get(),

        ], compact('id_kelas','task_id'));

    }
    public function quizAdd(request $request){
        // Validasi input dilakukan melalui StoreQuestionRequest
        // Validate the request, including the image input
            $validated = $request->validate([
                'soal' => 'required|string',
                'pilihan_a' => 'required|string',
                'pilihan_b' => 'required|string',
                'pilihan_c' => 'required|string',
                'pilihan_d' => 'required|string',
                'pilihan_e' => 'nullable|string',
                'jawaban' => 'required|in:A,B,C,D,E',
                'task_id' => 'required|integer',
            ]);

            // Save data to the Question model
            $question = new Question();
            $question->task_id = $validated['task_id'];
            $question->soal = $validated['soal'];
            $question->pilihan_a = $validated['pilihan_a'];
            $question->pilihan_b = $validated['pilihan_b'];
            $question->pilihan_c = $validated['pilihan_c'];
            $question->pilihan_d = $validated['pilihan_d'];
            $question->pilihan_e = $validated['pilihan_e'];
            $question->jawaban = $validated['jawaban'];

            $question->save();

            // Show success message and redirect
            toastr()->success('Pertanyaan Berhasil ditambahkan');
            return redirect()->back();
    }

    public function editQuiz($id_kelas, $id, $task_id){
        $task = tasks::where('id', $task_id)->first();
        $name = $task ? $task->judul : null;
        return view('plugin.classroom.work.quiz.quizUpdate',[
            'title'=>$name,
            'question'=>question::where('id',$id)->get()
        ],compact('id_kelas','id','task_id'));
    }

    public function quizUpdate(request $request){
        // Validate the input
        $validated = $request->validate([
            'soal' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'pilihan_e' => 'nullable|string',
            'jawaban' => 'required|in:A,B,C,D,E',
            'task_id' => 'required|integer',
            'id' => 'required|integer', // ID of the question to update
        ]);

        // Find the question by ID
        $question = Question::findOrFail($validated['id']);

        // Update the question details
        $question->soal = $validated['soal'];
        $question->pilihan_a = $validated['pilihan_a'];
        $question->pilihan_b = $validated['pilihan_b'];
        $question->pilihan_c = $validated['pilihan_c'];
        $question->pilihan_d = $validated['pilihan_d'];
        $question->pilihan_e = $validated['pilihan_e'] ?? null; // Pilihan E is optional
        $question->jawaban = $validated['jawaban'];
        $question->task_id = $validated['task_id'];

        // Save the updated question
        $question->save();
        toastr()->success('Pertanyaan Berhasil diubah');
        // Redirect with a success message
        return redirect()->back();
    }

    public function quizIndex($id_kelas ,$task_id){
        // Assuming you have the studentId from the authenticated user
        $studentId = auth()->user()->nomor;
        // Fetch the student's answers
        $studentAnswers = StudentAnswer::where('student_id', $studentId)
                                    ->pluck('answer', 'question_id')
                                    ->toArray();
        // Fetch the questions and options

        $time = tasks::where('id',$task_id)->first();
        $questions = question::where('task_id',$task_id)->get();  // Adjust based on your query logic
        $questionsAnswer = studentAnswer::where('student_id',$studentId)->get();  // Adjust based on your query logic

        $CekUpAnswer = StudentScore::where('task_id', $task_id)
        ->where('student_id', $studentId)
        ->get();

        $studentScore = StudentScore::where('student_id',$studentId)->first();
        return view('plugin.classroom.work.quiz.quiz',[
            'title'=>'Quiz',
            'questions'=>question::where('task_id',$task_id)->inRandomOrder()->get(),
            'questionsAnswer'=>$questionsAnswer,
            'time'=>$time->poin


        ],compact('task_id','questions', 'studentAnswers','studentScore','CekUpAnswer'));
    }

    public function quizSubmit(request $request){

            // Validate the incoming request
            $validated = $request->validate([
                'answer' => 'required|array', // Array of answers
                'answer.*' => 'required|string', // Each answer must be a string
                'question_id' => 'required|array', // Array of question IDs
                'question_id.*' => 'required|integer', // Each question ID must be an integer
                'student_id' => 'required|string', // Student ID is required
                'task_id' => 'required|integer', // Single task ID
            ]);

            // Retrieve data from the request
            $answers = $request->input('answer'); // Array of answers keyed by question_id
            $questionIds = $request->input('question_id'); // Array of question IDs
            $studentId = $request->input('student_id'); // Student ID
            $taskId = $request->input('task_id'); // Task ID

            $correctCount = 0; // Counter for correct answers
            $totalQuestions = count($questionIds); // Total number of questions

            // Initialize or reset the student's score for this task
            $studentScore = StudentScore::updateOrCreate(
                [
                    'task_id' => $taskId,
                    'student_id' => $studentId,
                ],
                [
                    'benar' => 0,
                    'nilai' => 0,
                ]
            );

            // Iterate over the question IDs to process answers
            foreach ($questionIds as $index => $questionId) {
                $studentAnswer = $answers[$questionId] ?? null; // Get the student's answer for this question

                if ($studentAnswer) {
                    // Fetch the question from the database
                    $question = question::where('task_id', $taskId)->where('id', $questionId)->first();

                    if ($question) {
                        // Map student answer to the correct format
                        $mappedAnswer = match ($studentAnswer) {
                            'A', 'B', 'C', 'D', 'E' => $studentAnswer,
                            default => null,
                        };

                        // Check if the student's answer matches the correct answer
                        $isCorrect = $mappedAnswer === $question->jawaban;

                        // Increment the correct answer count if the answer is correct
                        if ($isCorrect) {
                            $correctCount++;
                        }

                        // Update or create the student's answer in the StudentAnswer table
                        StudentAnswer::updateOrCreate(
                            [
                                'question_id' => $questionId,
                                'student_id' => $studentId,
                            ],
                            [
                                'answer' => $studentAnswer,
                                'is_correct' => $isCorrect ? 1 : 0, // Mark the answer as correct (1) or incorrect (0)
                            ]
                        );
                    }
                }
            }



            // Calculate the total score as a percentage (out of 100)
            $totalScore = ($correctCount / $totalQuestions) * 100;

            // Update the student's score in the StudentScore table
            $studentScore->benar = $correctCount; // Number of correct answers
            $studentScore->nilai = $totalScore;   // Total score (percentage)
            $studentScore->save();

            // Return a response with the results
            return response()->json([
                'status' => 'success',

            ]);

    }

    public function quizDelete($id){
        question::where('id',$id)->delete();
        toastr()->success('Pertanyaan Berhasil dihapus');
        // Redirect with a success message
        return redirect()->back();
    }

    public function quizFinish(request $request){

        StudentScore::where(['task_id'=>$request->task_id,'student_id'=>$request->student_id])->update([
            'status'=>$request->status,
            'finish_time'=>$request->finish_time,
        ]);
        toastr()->success('Terimakasih');
        return redirect()->route('index');
    }

    public function detailTugas($task_id, $id_kelas){
        $comments = Comment::where('task_id', $task_id)
        ->with('user')
        ->get();
        $files = fileTugas::where(['task_id'=> $task_id,'student_id'=>auth()->user()->nomor])->get();
        return view('plugin.classroom.taskdetail',[
            'title'=>'Detail Tugas',
                'myclass'=>ClassRoom::where('class_code',$id_kelas)->with('user')->get(),
                'task'=>tasks::where(['id_kelas'=>$id_kelas,'id'=>$task_id])->orderBy('id', 'DESC')->with(['media','links','user'])->get(),
                'comments'=>$comments,
                'peserta'=> fileTugas::where('task_id',$task_id)->with('student')->get(),
                'score'=>StudentScore::where(['task_id'=> $task_id])->with('StudentScore')->get()
        ],compact('task_id','id_kelas','files'));
    }

    public function filedelete($id){

       $cek = tasksmedia::find($id);

        // Check if the record exists
        if ($cek) {
            // Get the file path
            $path = $cek->file_path;
            // Delete the file from storage
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
            // Delete the record from the database
            $cek->delete();
        } else {
            // Handle if record doesn't exist (optional)
            return "Record not found!";
        }

        return redirect()->back();

    }

    public function linkdelete(request $request){
        // Get the task_id and link to delete from the request
    $taskId = $request->input('task_id');
    $linkToDelete = $request->input('link');

    // Find the task by task_id (corrected typo: fisrt() -> first())
    $task = taskslink::where('task_id', $taskId)->first();

    if ($task) {
        // Ensure youtube_link is an array or decoded JSON column
        $links = json_decode($task->youtube_link, true); // Decode JSON into an array (if it's stored as JSON)

        if (is_array($links)) {
            // Filter out the link that needs to be deleted
            $updatedLinks = array_filter($links, function ($link) use ($linkToDelete) {
                return $link !== $linkToDelete;
            });

            // Reindex the array to fix keys (optional but good practice)
            $updatedLinks = array_values($updatedLinks);

            // Update the youtube_link field with the updated links
            $task->update(['youtube_link' => json_encode($updatedLinks)]); // Re-encode to JSON

            // Return a success response
            return response()->json(['success' => true]);
        }

        // If the youtube_link is not an array or invalid, return error
        return response()->json(['success' => false, 'message' => 'Invalid links data'], 400);
    }

    // If the task was not found, return an error response
    return response()->json(['success' => false, 'message' => 'Task not found'], 404);
    }


    public function addAnnouncement(request $request){
        tasks::create([
            'judul' => $request->input('judul'),
            'description' => $request->input('description'),
            'id_kelas' => $request->input('id_kelas'),
            'type' => 'pengumuman',
            'created_by' =>$request->input('created_by'),

        ]);
        toastr()->success('Data Berhasil dipublikasikan');
        return redirect()->back();
    }

}
