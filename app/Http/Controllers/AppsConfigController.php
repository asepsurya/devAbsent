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
                }elseif($request->type ==='kartu'){
                    Setting::where('key', 'signature_city')->update(['value' => $request->signature_city]);
                    Setting::where('key', 'signature_date')->update(['value' => $request->signature_date]);
                    Setting::where('key', 'signature_date')->update(['value' => $request->signature_date]);
                    // untuk tandatangan
                    if ($request->file('signature')) {
                        // Delete old logo and favicon files if they exist
                        if ($request->oldimage) {
                            Storage::delete($request->oldimage);
                        }
                        $logoPath = $request->file('signature')->store('config');
                        Setting::where('key', 'signature')->update(['value' => $logoPath]);
                    }
                     // untuk stempel
                    if ($request->file('signature_stamp')) {
                       // Delete old logo and favicon files if they exist
                        if ($request->oldimage) {
                            Storage::delete($request->oldimage);
                        }
                        $logoPath = $request->file('signature_stamp')->store('config');
                        Setting::where('key', 'signature_stamp')->update(['value' => $logoPath]);
                    }

                      // untuk Background back
                      if ($request->file('studentBG_back_default')) {
                        // Delete old logo and favicon files if they exist
                         if ($request->bg_old) {
                             Storage::delete($request->bg_old);
                         }
                         $logoPath = $request->file('studentBG_back_default')->store('config');
                         Setting::where('key', 'studentBG_back_default')->update(['value' => $logoPath]);
                     }

                      // untuk Background front
                      if ($request->file('studentBG_front_default')) {
                        // Delete old logo and favicon files if they exist
                         if ($request->bg_old) {
                             Storage::delete($request->bg_old);
                         }
                         $logoPath = $request->file('studentBG_front_default')->store('config');
                         Setting::where('key', 'studentBG_front_default')->update(['value' => $logoPath]);
                     }

                        
                     // untuk Background front
                     if ($request->file('gtkBG_front_default')) {
                        // Delete old logo and favicon files if they exist
                         if ($request->bg_old) {
                             Storage::delete($request->bg_old);
                         }
                         $logoPath = $request->file('gtkBG_front_default')->store('config');
                         Setting::where('key', 'gtkBG_front_default')->update(['value' => $logoPath]);
                     }

                      // untuk Background back
                      if ($request->file('gtkBG_back_default')) {
                        // Delete old logo and favicon files if they exist
                         if ($request->bg_old) {
                             Storage::delete($request->bg_old);
                         }
                         $logoPath = $request->file('gtkBG_back_default')->store('config');
                         Setting::where('key', 'gtkBG_back_default')->update(['value' => $logoPath]);
                     }



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
                    Setting::where('key', 'nama_yayasan')->update(['value' => $request->nama_yayasan]);
                    Setting::where('key', 'signature_position')->update(['value' => $request->signature_position]);
                   

                }
            
        });

        // Clear the cache
        Artisan::call('optimize:clear');
        toastr()->success('Setelan Berhasil disimpan');
        // Redirect with success message
        if($request->type === 'sistem'){
            return redirect()->route('setelan.sistem')->with('status', 'success Update');
        }elseif($request->type === 'kartu'){
            return redirect()->route('setelan.card')->with('status', 'success Update');
        }else{
            return redirect()->route('setelan.app')->with('status', 'success Update');
        }


    }
 
    public function reset(){
        if(request('auth') == 'gtk'){
            if(request('section' ) === 'front'){
                Setting::where('key', 'gtkBG_front_default')->update(['value' => '']);
            }
            if(request('section')=== 'back'){
                Setting::where('key', 'gtkBG_back_default')->update(['value' => '']);
            }
        }else{
            if(request('section' ) === 'front'){
                Setting::where('key', 'studentBG_front_default')->update(['value' => '']);
            }
            if(request('section')=== 'back'){
                Setting::where('key', 'studentBG_back_default')->update(['value' => '']);
            }
        }
       
        Artisan::call('optimize:clear');
        return redirect()->back();
    }

    public function schoolTime(request $request){
        Setting::where('key', 'start_school')->update(['value' => $request->start_school]);
        Setting::where('key', 'waktu_mapel')->update(['value' => $request->waktu_mapel]);

        Artisan::call('cache:clear');
        toastr()->success('Setelan Berhasil disimpan');
        return redirect()->back();
    }
}
