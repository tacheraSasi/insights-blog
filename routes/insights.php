<?php 
use App\Http\Controllers\InsightController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('insights', InsightController::class);
    Route::post('insights/{insight}/like', [LikeController::class, 'store'])->name('insights.like');
    Route::post('insights/{insight}/comments', [CommentController::class, 'store'])->name('comments.store');
});
