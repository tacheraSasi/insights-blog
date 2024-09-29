<?php

use App\Http\Controllers\InsightController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * add insight
 * all insights
 * update insight
 * delete insight
 * comments on each insight
 * 
 */

Route::get('/', function () {
    // dd (Auth::user());
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect(route("home"));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/home', [InsightController::class,"home"])->middleware(['auth', 'verified'])->name('home');

Route::get("/write", function(){
    return ["route"=>"home","write"=> "write posts"];
})->name("write");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/insights.php';
require __DIR__.'/auth.php';
