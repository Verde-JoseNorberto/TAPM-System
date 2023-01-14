<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupProjectController;

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
    }else if (auth()->user()->type == 'client') {
        return redirect()->route('client/home');
    }else{
        return redirect()->route('student/home');
    }
})->middleware('auth');


Auth::routes();
  
Route::middleware(['auth', 'user-access:student'])->group(function () {
  
    Route::get('/home', [App\Http\Controllers\UserController::class, 'studentHome'])->name('student/home');
});
  
Route::middleware(['auth', 'user-access:faculty'])->group(function () {
  
    Route::get('/faculty/home', [App\Http\Controllers\UserController::class, 'facultyHome'])->name('faculty/home');
});
  
Route::middleware(['auth', 'user-access:client'])->group(function () {
  
    Route::get('/client/home', [App\Http\Controllers\UserController::class, 'clientHome'])->name('client/home');
});

Route::get('/project', [App\Http\Controllers\GroupProjectController::class, 'index'])
    ->name('student/project') or name('student/project') or name('student/project');
Route::post('/project', [App\Http\Controllers\GroupProjectController::class, 'store'])->name('faculty/project');