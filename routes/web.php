<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupProjectController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->user()->type == 'faculty') {
        return redirect()->route('faculty/home');
    }else if (auth()->user()->type == 'office') {
        return redirect()->route('office/home');
    }else{
        return redirect()->route('student/home');
    }
})->middleware('auth');

Auth::routes(['verify' => true]);
Route::middleware(['auth', 'user-access:office'])->group(function () {
    Route::get('/office/home', [App\Http\Controllers\UserController::class, 'officeHome'])->name('office/home');
    Route::get('/office/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('office/home');
    Route::get('/office/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/office/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/office/project/{id}/edit', [App\Http\Controllers\GroupProjectController::class, 'edit']);
    Route::get('/office/admin', [App\Http\Controllers\GroupProjectController::class, 'admin'])->name('office/admin');
});
Route::middleware(['auth', 'user-access:faculty'])->group(function () {
    Route::get('/faculty/home', [App\Http\Controllers\UserController::class, 'facultyHome'])->name('faculty/home');
    Route::get('/faculty/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/home');
    Route::get('/faculty/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/faculty/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/faculty/project/{id}/edit', [App\Http\Controllers\GroupProjectController::class, 'edit']);

});
Route::middleware(['auth', 'user-access:student'])->group(function () {
    Route::get('/home', [App\Http\Controllers\UserController::class, 'studentHome'])->name('student/home');
    Route::get('/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('student/home');
    Route::get('/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);

});

Route::controller(GroupProjectController::class)->group(function() {
    Route::post('faculty/home', 'groupStore')->name('faculty/project');
    Route::post('office/home', 'groupStore')->name('office/project');
    
    Route::post('/project', 'projectStore')->name('student/project');

    Route::post('project/task', 'taskStore')->name('student/task');

    Route::put('faculty/edit/{id}', 'groupUpdate')->name('faclty/edit');
});

Route::controller(CommentController::class)->group(function(){
    Route::post('faculty/feedback', 'store')->name('faculty/feedback');
    Route::post('office/project', 'store')->name('office/project');
    Route::post('/feedback', 'store')->name('student/feedback');
});