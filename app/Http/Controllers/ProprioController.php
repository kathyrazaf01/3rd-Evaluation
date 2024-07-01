<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProprioController extends Controller
{
    public function detailsbien($idbien){
        $idbien = session('idbien');

        $results = DB::select('select distinct nombien,region,loyer from viewpropbien where idbien = ?', [$idbien]);
        $photos = DB::select('select nomphoto from viewpropbien  where idbien = ?', [$idbien]);
    
        return view('proprietaire/detailsbien', ['results' => $results, 'photos' => $photos]);
    }
}
