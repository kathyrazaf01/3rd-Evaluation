<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => ['check.client.session']], function () {
   
//     // Vous pouvez ajouter plus de routes 
// });

Route::get('/main', function () {
    return view('main');
})->name('main');


Route::get('/', function () {
    return view('login/loginclient');
})->name('loginclient');

Route::get('/admin', function () {
    return view('login/loginadmin');
})->name('loginadmin');

Route::get('/proprietaire', function () {
    return view('login/loginproprietaire');
})->name('loginproprietaire');

Route::get('/indexclient', function () {
    return view('client/indexclient');
})->name('indexclient');

Route::get('/detailslocation', function () {
    return view('client/detailslocation');
})->name('detailslocation');

Route::post('/logclient', [LoginController::class, 'logclient'])->name('logclient');

Route::post('/filtredate', [ClientController::class, 'filtredate'])->name('filtredate');



Route::get('/detailslocation/{idbien}', [ClientController::class, 'detailslocation'])->name('detailslocation');

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
