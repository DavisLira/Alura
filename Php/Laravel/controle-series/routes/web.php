<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginContoller;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use App\Mail\SeriesCreated;
use Illuminate\Support\Facades\Route;

Route::resource('/series', SeriesController::class)
    ->except(['show']);

Route::middleware('authenticator')->group(function () {
    Route::get('/', function () {
        return redirect('/series');
    });
    
    Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');
    
    Route::get('seasons/{season}/episodes', [EpisodesController::class, 'index'])->name('episodes.index');
    Route::post('seasons/{season}/episodes', [EpisodesController::class, 'update'])->name('episodes.update');
});

Route::get('/email', function () {
    return new SeriesCreated(
        'Série teste',
        3, 5, 10
    );
});

Route::get('/login', [LoginContoller::class, 'index'])->name('login');
Route::post('/login', [LoginContoller::class, 'store'])->name('signin');
Route::post('/logout', [LoginContoller::class, 'destroy'])->name('logout');

Route::get('/register', [UsersController::class, 'create'])->name('users.create');
Route::post('/register', [UsersController::class, 'store'])->name('users.store');