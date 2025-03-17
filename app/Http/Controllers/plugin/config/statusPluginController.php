<?php

namespace App\Http\Controllers\plugin\config;

use App\Models\plugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class statusPluginController extends Controller
{
    public function statusPlugin(){
        $id = request('val');
        if(request('class')== 'nonactive'){
            plugin::where('alias',$id)->update([
                'status'=> '2'
            ]);
        }else{
            plugin::where('alias',$id)->update([
                'status'=> '1'
            ]);
        }
    }

    private function nonActive(){
        
    }
}
