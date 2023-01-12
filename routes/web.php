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
    return view('auth.login');
})->name('login');

Route::get('/project', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/project');
Route::post('/project', [App\Http\Controllers\GroupProjectController::class, 'store'])->name('faculty/project');

Auth::routes();
// Route::get('/home', [App\Http\Controllers\StudentController::class, 'index'])->name('student/home');
Route::get('/home', [App\Http\Controllers\FacultyController::class, 'index'])->name('faculty/home');
// Route::get('/home', [App\Http\Controllers\ClientController::class, 'index'])->name('clienthome');
Auth::routes();