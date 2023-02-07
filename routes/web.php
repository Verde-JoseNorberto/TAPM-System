<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupProjectController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

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
    }else if (auth()->user()->type == 'office') {
        return redirect()->route('office/home');
    }else{
        return redirect()->route('student/home');
    }
})->middleware('auth');

Auth::routes(['verify' => true]);
Route::middleware(['auth', 'user-access:student'])->group(function () {
    Route::get('/home', [App\Http\Controllers\UserController::class, 'studentHome'])->name('student/home');
    Route::get('/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('student/home');
});
Route::middleware(['auth', 'user-access:faculty'])->group(function () {
    Route::get('/faculty/home', [App\Http\Controllers\UserController::class, 'facultyHome'])->name('faculty/home');
    Route::get('/faculty/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/home');
});
Route::middleware(['auth', 'user-access:client'])->group(function () {
    Route::get('/client/home', [App\Http\Controllers\UserController::class, 'clientHome'])->name('client/home');
    Route::get('/client/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('client/home');
});
Route::middleware(['auth', 'user-access:office'])->group(function () {
    Route::get('/office/home', [App\Http\Controllers\UserController::class, 'officeHome'])->name('office/home');
    Route::get('/office/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('office/home');
});

Route::controller(GroupProjectController::class)->group(function() {
    Route::post('faculty/project', 'groupStore')->name('faculty/project');
    Route::post('/project', 'projectStore')->name('student/project');
    // Route::post('/project', 'taskStore')->name('student/project');

    Route::get('faculty/project/{id}/edit', 'edit')->name('faculty/edit');
    Route::put('faculty/project/{id}', 'update');

    Route::get('/project/{id}', 'show');
    Route::get('/faculty/project/{id}', 'show');
    Route::get('/client/project/{id}', 'show');
    Route::get('/office/project/{id}', 'show');

    Route::delete('faculty/project', 'destroy');
    Route::delete('student/project', 'destroy');
});

Route::controller(GroupController::class)->group(function() {
    Route::get('faculty/group', 'index')->name('faculty/group');
    Route::get('office/group', 'index')->name('office/group');
});