<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('main');

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
