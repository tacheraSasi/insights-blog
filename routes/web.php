<?php

use App\Http\Controllers\InsightController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
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
    $insights = Insight::with('category', 'user', 'likes', 'comments', 'tags')->latest()->paginate(6);
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

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search', [SearchController::class, 'api'])->name('search.api');

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

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/insights', [AdminController::class, 'insights'])->name('insights');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/tags', [AdminController::class, 'tags'])->name('tags');
});

require __DIR__.'/insights.php';
require __DIR__.'/auth.php';
