<?php

use App\Http\Controllers\InsightController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsoleController;
use App\Models\Insight;
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
    if(Auth::check()){
        return redirect(route("home"));
    }
    $insights = Insight::with('category', 'user', 'likes', 'comments')->latest()->paginate(6);
    return view('welcome', compact('insights'));
    
});

//Fallback route 404
Route::fallback((function(){
    return view("errors.404");
}));


Route::get('/dashboard', function () {
    return redirect(route("home"));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/home', [InsightController::class,"index"])->middleware(['auth', 'verified'])->name('home');

#Console
// Route::get('/console',)

// Route::get("/write", function(){
//     return ["route"=>"home","write"=> "write posts"];
// })->name("write");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/console', [ConsoleController::class, 'index'])->name('console.index');
    Route::get('/console/send-email', [ConsoleController::class, 'showEmailForm'])->name('console.email.form');
    Route::post('/console/send-email', [ConsoleController::class, 'sendEmailToAllUsers'])->name('console.email.send');
});

require __DIR__.'/insights.php';
require __DIR__.'/auth.php';
