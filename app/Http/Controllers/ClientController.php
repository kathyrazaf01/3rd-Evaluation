<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class ClientController extends Controller
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    


    public function detailslocation($idbien){   

        $idbien = $idbien ?? request()->route('idbien');
        return view('client/detailslocation', ['idbien' => $idbien]);
        
    }

    public function filtredate(Request $request){

        $date1 = $request->date1;
        $date2 = $request->date2;
        $idbien = $request->idbien;
        $duree = $this->client->dureelocation($date1,$date2,$idbien);
        $showlocations = $this->client->showloyer($date1,$date2,$idbien,$duree);
        return view('client/detailslocation', ['showlocations' => $showlocations,'idbien' => $idbien]);
    }

    
}
