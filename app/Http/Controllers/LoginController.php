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

    public function logproprio(Request $request)
    {
        $telephone = $request->input('telephone'); // Assurez-vous de vérifier le mot de passe dans votre logique

        if (empty($telephone)) {
            return redirect()->back()->with('error', 'remplir le champ');
        }

        $proprietaire = DB::table('proprietaire')->where('telephone', $telephone)->first();

        if ($proprietaire) {
            Session::put('idprop', $proprietaire->idprop);
            return redirect()->route('indexproprio', ['idprop' => $proprietaire->idprop]);
        } else {
            return redirect()->back()->with('error', 'telephone Invalid');
        }
    }

    public function logadmin(Request $request)
    {
        $nomadmin = $request->input('nomadmin'); // Assurez-vous de vérifier le mot de passe dans votre logique
        $mdp = $request->input('mdp'); // Assurez-vous de vérifier le mot de passe dans votre logique

        if (empty($nomadmin) || empty($mdp)) {
            return redirect()->back()->with('error', 'remplir le champ');
        }

        $admin = DB::table('admin')
            ->where('nomadmin', $nomadmin)
            ->where('mdp', $mdp)
            ->first();

        if ($admin) {
            Session::put('idadmin', $admin->idadmin);
            return redirect()->route('indexadmin', ['idadmin' => $admin->idadmin]);
        } else {
            return redirect()->back()->with('error', 'Datas Invalid');
        }
    }


    public function deconnexionclient(){
        Session::forget('idclient');
        return redirect('/');
    }

    public function deconnexionprop(){
        Session::forget('idprop');
        return redirect('loginproprietaire');
    }

    public function deconnexionadmin(){
        Session::forget('idadmin');
        return redirect('loginadmin');
    }
}
