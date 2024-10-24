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
            'title'=> 'Setelan Aplikasi',
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
                Setting::where('key', 'register')->update(['value' => $request->register]);

        });

        // Clear the cache
        Artisan::call('cache:clear');
        toastr()->success('Setelan Berhasil disimpan');
        // Redirect with success message
        return redirect()->route('setelan.app')->with('status', 'success Update');

    }
}
