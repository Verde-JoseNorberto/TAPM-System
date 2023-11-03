<?php

use Illuminate\Support\Facades\Route;

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

// Authenticate user, if login, proceed to home.
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

// Super Privilege View or the Office/Client View
Route::middleware(['auth', 'user-access:office'])->group(function () {
    Route::get('/office/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('office/home');
    Route::get('/office/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'projectShow']);
    Route::get('/office/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/office/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::get('/office/project/{id}/edit', [App\Http\Controllers\GroupProjectController::class, 'edit']);
    Route::post('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('office/home');
    Route::post('office/project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('office/task');
    Route::post('office/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackStore'])->name('office/feedback');
    Route::post('office/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('office/team');
    Route::put('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupUpdate'])->name('office/edit');
    Route::put('office/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('office/board');
    Route::delete('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupDestroy']);
    Route::delete('office/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('office/project/team', [App\Http\Controllers\GroupProjectController::class, 'teamDestroy']);
    Route::delete('office/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackDestroy'])->name('office/feedDel');

    // Admin Privilege
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin/index');
    Route::get('/admin/user', [App\Http\Controllers\AdminController::class, 'userShow'])->name('admin/user');
    Route::get('/admin/group', [App\Http\Controllers\AdminController::class, 'groupShow'])->name('admin/group');
    Route::get('/admin/project', [App\Http\Controllers\AdminController::class, 'projectShow'])->name('admin/project');
    Route::get('/admin/task', [App\Http\Controllers\AdminController::class, 'taskShow'])->name('admin/task');
    Route::get('/admin/team', [App\Http\Controllers\AdminController::class, 'teamShow'])->name('admin/team');
    Route::get('/admin/feedback', [App\Http\Controllers\AdminController::class, 'feedbackShow'])->name('admin/feedback');
    Route::post('admin/user', [App\Http\Controllers\AdminController::class, 'userStore'])->name('admin/user');
    Route::put('admin/user', [App\Http\Controllers\AdminController::class, 'userUpdate']);
    Route::delete('admin/user', [App\Http\Controllers\AdminController::class, 'userDestroy']);
    Route::delete('admin/group', [App\Http\Controllers\AdminController::class, 'groupDestroy']);
    Route::delete('admin/project', [App\Http\Controllers\AdminController::class, 'projectDestroy']);
    Route::delete('admin/task', [App\Http\Controllers\AdminController::class, 'taskDestroy']);
    Route::delete('admin/team', [App\Http\Controllers\AdminController::class, 'teamDestroy']);
    Route::delete('admin/feedback', [App\Http\Controllers\AdminController::class, 'feedbackDestroy']);
});

// Special Privilege View or the Faculty View
Route::middleware(['auth', 'user-access:faculty'])->group(function () {
    Route::get('/faculty/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/home');
    Route::get('/faculty/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'projectShow']);
    Route::get('/faculty/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/faculty/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::post('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('faculty/home');
    Route::post('faculty/project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('faculty/task');
    Route::post('faculty/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('faculty/team');
    Route::post('faculty/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackStore'])->name('faculty/feedback');
    Route::put('faculty/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('faculty/board');
    Route::delete('faculty/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('faculty/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackDestroy'])->name('faculty/feedDel');
});

// Regular Privilege View or the Student View
Route::middleware(['auth', 'user-access:student'])->group(function () {
    Route::get('/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('student/home');
    Route::get('/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'projectShow']);
    Route::get('/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::post('/project', [App\Http\Controllers\GroupProjectController::class, 'projectStore'])->name('student/project');
    Route::post('project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('student/task');
    Route::post('/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackStore'])->name('student/feedback');
    Route::put('student/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('student/board');
    Route::delete('student/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('student/post', [App\Http\Controllers\GroupProjectController::class, 'projectDestroy'])->name('student/post');
    Route::delete('student/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackDestroy'])->name('student/feedDel');
});