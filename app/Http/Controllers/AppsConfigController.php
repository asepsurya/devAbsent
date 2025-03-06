<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class AppsConfigController extends Controller
{
    Public function app(){
        return view('setelan.apps',[
            'title'=> 'Pengaturan Sekolah',
            'settings'=>Setting::get(['key','value'])
        ]);
    }
    Public function card(){
        return view('setelan.card',[
            'title'=> 'Pengaturan Layout Kartu',
            'settings'=>Setting::get(['key','value'])
        ]);
    }
    Public function sistem(){
        return view('setelan.system',[
            'title'=> 'Pengaturan Aplikasi',
            'settings'=>Setting::get(['key','value'])
        ]);
    }

    public function customize(){
        return view('setelan.custumize',[
            'title'=> 'Customize'
        ]);
    }

    public function appChange(request $request){
        $inputData = $request->except('_token');

        DB::transaction(function () use ($request, $inputData) {
                if($request->type === 'sistem'){
                    Setting::where('key', 'register')->update(['value' => $request->register]);
                    Setting::where('key', 'instagram_userID')->update(['value' => $request->userid]);
                    Setting::where('key', 'instagram_access_token')->update(['value' => $request->access_token]);
                }else{
                    // Store new logo and favicon and update settings
                    if ($request->file('site_logo')) {
                        // Delete old logo and favicon files if they exist
                    if ($request->logoOld) {
                        Storage::delete($request->logoOld);
                    }
                    $logoPath = $request->file('site_logo')->store('config');
                    Setting::where('key', 'site_logo')->update(['value' => $logoPath]);
                }

                if ($request->file('site_fav')) {
                        // Delete old logo and favicon files if they exist
                    if ($request->favOld) {
                        Storage::delete($request->favOld);
                    }
                    $favPath = $request->file('site_fav')->store('config');
                    Setting::where('key', 'site_fav')->update(['value' => $favPath]);
                }

                    Setting::where('key', 'site_name')->update(['value' => $request->site_name]);
                    Setting::where('key', 'slogan')->update(['value' => $request->slogan]);
                    Setting::where('key', 'address')->update(['value' => $request->address]);
                    Setting::where('key', 'phone')->update(['value' => $request->phone]);
                    Setting::where('key', 'email')->update(['value' => $request->email]);
                    Setting::where('key', 'fax')->update(['value' => $request->fax]);
                    Setting::where('key', 'headmaster')->update(['value' => $request->headmaster]);
                    Setting::where('key', 'headmasterid')->update(['value' => $request->headmasterid]);
                }

        });

        // Clear the cache
        Artisan::call('cache:clear');
        toastr()->success('Setelan Berhasil disimpan');
        // Redirect with success message
        if($request->type === 'sistem'){
            return redirect()->route('setelan.sistem')->with('status', 'success Update');
        }else{
            return redirect()->route('setelan.app')->with('status', 'success Update');
        }


    }

    public function schoolTime(request $request){
        Setting::where('key', 'start_school')->update(['value' => $request->start_school]);
        Setting::where('key', 'waktu_mapel')->update(['value' => $request->waktu_mapel]);

        Artisan::call('cache:clear');
        toastr()->success('Setelan Berhasil disimpan');
        return redirect()->back();
    }
}
