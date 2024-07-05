<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProprioController;
use App\Http\Controllers\AdminController;

use App\Models\Proprio;
use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['check.client.session']], function () {
    Route::get('/indexclient', function () {
        return view('client/indexclient');
    })->name('indexclient');
    // Ajoutez ici d'autres routes protégées par la session
});


// Route::group(['middleware' => ['check.client.session']], function () {
   
//     // Vous pouvez ajouter plus de routes 
// });

Route::get('/main', function () {
    return view('main');
})->name('main');


Route::get('/', function () {
    return view('login/loginclient');
})->name('loginclient');

Route::get('/loginadmin', function () {
    return view('login/loginadmin');
})->name('loginadmin');

Route::get('/loginproprietaire', function () {
    return view('login/loginproprietaire');
})->name('loginproprietaire');

Route::get('/indexclient', function () {
    return view('client/indexclient');
})->name('indexclient');


Route::get('/indexproprio', function () {
    return view('proprietaire/indexproprio');
})->name('indexproprio');

Route::get('/importcsvbien', function () {
    return view('admin/importcsvbien');
})->name('importcsvbien');

Route::get('/importcsvlocation', function () {
    return view('admin/importcsvlocation');
})->name('importcsvlocation');

Route::get('/insertlocation', function () {
    return view('admin/insertlocation');
})->name('insertlocation');


Route::get('/listebien', function () {
    return view('admin/listebien');
})->name('listebien');

Route::get('/indexadmin', [AdminController::class, 'showpaiement'])->name('indexadmin');

Route::get('/listebien', [AdminController::class, 'listebien'])->name('listebien');

Route::post('/logclient', [LoginController::class, 'logclient'])->name('logclient');

Route::post('/logproprio', [LoginController::class, 'logproprio'])->name('logproprio');

Route::post('/logadmin', [LoginController::class, 'logadmin'])->name('logadmin');

Route::get('/detailslocation/{idbien}', [ClientController::class, 'detailslocation'])->name('detailslocation');

Route::post('/importbien', [AdminController::class, 'importcsvbien'])->name('importbien');

Route::post('/importlocation', [AdminController::class, 'importlocation'])->name('importlocation');

Route::get('/detailsproprio/{idproprio}', [ProprioController::class, 'detailsproprio'])->name('detailsproprio');

Route::get('/showchart', [AdminController::class, 'showchart'])->name('showchart');

Route::get('/delete', [AdminController::class, 'delete'])->name('delete');

Route::get('/detailstypebien/{idbien}', [AdminController::class, 'detailstypebien'])->name('detailstypebien');

Route::post('/insertnewlocation', [AdminController::class, 'insertnewlocation'])->name('insertnewlocation');

Route::get('/detailsbien/{idbien}', [ProprioController::class, 'detailsbien'])->name('detailsbien');

Route::post('/filtredate', [ClientController::class, 'filtredate'])->name('filtredate');

Route::get('/deconnexionclient', [LoginController::class, 'deconnexionclient'])->name('deconnexionclient');

Route::get('/deconnexionadmin', [LoginController::class, 'deconnexionadmin'])->name('deconnexionadmin');

Route::get('/deconnexionprop', [LoginController::class, 'deconnexionprop'])->name('deconnexionprop');


Route::get('/404', function () {
    return view('404');
})->name('404');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::get('/button', function () {
    return view('button');
})->name('button');

Route::get('/chart', function () {
    return view('chart');
})->name('chart');

Route::get('/element', function () {
    return view('element');
})->name('element');

Route::get('/form', function () {
    return view('form');
})->name('form');


Route::get('/signin', function () {
    return view('signin');
})->name('signin');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::get('/table', function () {
    return view('table');
})->name('table');

Route::get('/typography', function () {
    return view('typography');
})->name('typography');

Route::get('/widget', function () {
    return view('widget');
})->name('widget');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
