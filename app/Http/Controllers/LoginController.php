<?php

namespace App\Http\Controllers;

use App\Models\Login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function logclient(Request $request)
    {
        $email = $request->input('email'); // Assurez-vous de vérifier le mot de passe dans votre logique

        if (empty($email)) {
            return redirect()->back()->with('error', 'remplir le champ');
        }

        $client = DB::table('client')->where('email', $email)->first();

        if ($client) {
            Session::put('idclient', $client->idclient);
            return redirect()->route('indexclient', ['idclient' => $client->idclient]);
        } else {
            return redirect()->back()->with('error', 'email Invalid');
        }
    }
}
