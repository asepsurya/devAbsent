<?php

namespace App\Http\Controllers;
use App\Services\InstagramService;
use Illuminate\Http\Request;
use App\Models\absentsHistory;

class landingController extends Controller
{
    protected $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    public function index(){
        $userId = app('settings')['instagram_userID'] ?? env('INSTAGRAM_USER_ID'); // your Instagram user ID
        $username = $this->instagramService->getUsername($userId);  // Fetch username
        $feed = $this->instagramService->getFeed($userId);

        if(app('settings')['device'] == 'device1'){
            return view('frontpage.myIndex',[
                'absent'=>absentsHistory::where('date',date('d/m/Y'))->count()
            ],compact('feed','username'));
        }else{
            return view('frontpage.index',[
                'absent'=>absentsHistory::where('date',date('d/m/Y'))->count()
            ],compact('feed','username'));
        }
       
    }

    public function listabsents(){
        $data = absentsHistory::where('date',date('d/m/Y'))->with(['student','gtk'])->orderBy('id','DESC')->get();
        return  json_encode($data);
    }

    public function home(){
        return view('frontpage.myIndex');
    }





}
