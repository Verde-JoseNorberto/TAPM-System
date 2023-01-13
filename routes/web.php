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
    // return view('student.home') or view('faculty.home') or view('client.home');
    return view('auth.login');
// })->middleware('auth');
})->name('login');

Auth::routes();
  
Route::middleware(['auth', 'user-access:student'])->group(function () {
  
    Route::get('/home', [UserController::class, 'studentHome'])->name('student/home');
});
  
Route::middleware(['auth', 'user-access:faculty'])->group(function () {
  
    Route::get('/faculty/home', [UserController::class, 'facultyHome'])->name('faculty/home');
});
  
Route::middleware(['auth', 'user-access:client'])->group(function () {
  
    Route::get('/client/home', [UserController::class, 'clientHome'])->name('client/home');
});

Route::get('/project', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/project');
Route::post('/project', [App\Http\Controllers\GroupProjectController::class, 'store'])->name('faculty/project');