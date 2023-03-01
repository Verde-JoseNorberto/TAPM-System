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

// Authenticate user, if login, proceed to home.
Route::get('/', function () {
    if (auth()->user()->type == 'adviser') {
        return redirect()->route('faculty/home');
    }else if (auth()->user()->type == 'teacher') {
        return redirect()->route('teacher/home');
    }else if (auth()->user()->type == 'office') {
        return redirect()->route('office/home');
    }else{
        return redirect()->route('student/home');
    }
})->middleware('auth');

Auth::routes(['verify' => true]);

// Super Privilege View or the Office/Client View
Route::middleware(['auth', 'user-access:office'])->group(function () {
    Route::get('/office/home', [App\Http\Controllers\UserController::class, 'officeHome'])->name('office/home');
    Route::get('/office/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('office/home');
    Route::get('/office/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/office/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/office/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::get('/office/project/{id}/edit', [App\Http\Controllers\GroupProjectController::class, 'edit']);
    Route::post('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('office/home');
    Route::post('office/project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('office/task');
    Route::post('office/feedback', [App\Http\Controllers\CommentController::class, 'store'])->name('office/feedback');
    Route::post('office/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('office/team');
    Route::put('office/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('office/board');

    // Admin Privilege
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin/index');
    Route::get('/admin/user', [App\Http\Controllers\AdminController::class, 'userShow'])->name('admin/user');
    Route::get('/admin/group', [App\Http\Controllers\AdminController::class, 'groupShow'])->name('admin/group');
    Route::get('/admin/project', [App\Http\Controllers\AdminController::class, 'projectShow'])->name('admin/project');
    Route::get('/admin/task', [App\Http\Controllers\AdminController::class, 'taskShow'])->name('admin/task');
    Route::get('/admin/feedback', [App\Http\Controllers\AdminController::class, 'feedbackShow'])->name('admin/feedback');
    Route::post('admin/user', [App\Http\Controllers\AdminController::class, 'store'])->name('admin/user');
    Route::put('admin/user', [App\Http\Controllers\AdminController::class, 'userUpdate']);
    Route::delete('admin/project', [App\Http\Controllers\AdminController::class, 'projectDestroy']);
});

// Special Privilege View or the Faculty View
Route::middleware(['auth', 'user-access:adviser'])->group(function () {
    Route::get('/faculty/home', [App\Http\Controllers\UserController::class, 'facultyHome'])->name('faculty/home');
    Route::get('/faculty/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/home');
    Route::get('/faculty/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/faculty/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/faculty/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::post('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('faculty/home');
    Route::post('faculty/project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('faculty/task');
    Route::post('faculty/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('faculty/team');
    Route::post('faculty/feedback', [App\Http\Controllers\CommentController::class, 'store'])->name('faculty/feedback');
    Route::put('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupUpdate'])->name('faculty/edit');
    Route::put('faculty/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('faculty/board');
    Route::delete('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupDestroy']);
});

// Special Privilege View or the Teacher View
Route::middleware(['auth', 'user-access:teacher'])->group(function () {
    Route::get('/teacher/home', [App\Http\Controllers\UserController::class, 'teacherHome'])->name('teacher/home');
    Route::get('/teacher/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('teacher/home');
    Route::get('/teacher/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/teacher/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/teacher/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::post('teacher/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('teacher/home');
    Route::post('teacher/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('teacher/team');
    Route::post('teacher/feedback', [App\Http\Controllers\CommentController::class, 'store'])->name('teacher/feedback');
    Route::put('teacher/home', [App\Http\Controllers\GroupProjectController::class, 'groupUpdate'])->name('teacher/edit');
    Route::delete('teacher/home', [App\Http\Controllers\GroupProjectController::class, 'groupDestroy']);
});

// Regular Privilege View or the Student View
Route::middleware(['auth', 'user-access:student'])->group(function () {
    Route::get('/home', [App\Http\Controllers\UserController::class, 'studentHome'])->name('student/home');
    Route::get('/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('student/home');
    Route::get('/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'show']);
    Route::get('/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    Route::post('/project', [App\Http\Controllers\GroupProjectController::class, 'projectStore'])->name('student/project');
    Route::post('project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('student/task');
    Route::post('/feedback', [App\Http\Controllers\CommentController::class, 'store'])->name('student/feedback');
    Route::put('student/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('student/board');
    Route::delete('student/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('student/project', [App\Http\Controllers\GroupProjectController::class, 'projectDestroy'])->name('student/post');
});