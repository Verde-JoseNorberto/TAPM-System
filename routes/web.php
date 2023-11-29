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
    Route::get('/office/project/{id}/task-{id2}', [App\Http\Controllers\GroupProjectController::class, 'subShow']);
    Route::get('/office/project/{id}/event', [App\Http\Controllers\GroupProjectController::class, 'eventShow']);
    Route::get('/office/project/{id}/progress', [App\Http\Controllers\GroupProjectController::class, 'chartShow']);
    Route::get('/office/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);

    Route::post('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('office/home');
    Route::post('office/project', [App\Http\Controllers\GroupProjectController::class, 'projectStore'])->name('office/project');
    Route::post('office/project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('office/task');
    Route::post('office/project/subtask', [App\Http\Controllers\GroupProjectController::class, 'subStore'])->name('office/subtask');
    Route::post('office/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackStore'])->name('office/feedback');
    Route::post('office/project/event', [App\Http\Controllers\GroupProjectController::class, 'eventStore'])->name('office/event');
    Route::post('office/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('office/team');
    
    Route::put('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupUpdate'])->name('office/edit');
    Route::put('office/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('office/detail');
    Route::put('office/subtask', [App\Http\Controllers\GroupProjectController::class, 'subUpdate'])->name('office/update');
    Route::put('office/event', [App\Http\Controllers\GroupProjectController::class, 'eventUpdate'])->name('office/eveUp');
    Route::put('office/team', [App\Http\Controllers\GroupProjectController::class, 'teamUpdate'])->name('office/editTeam');

    Route::delete('office/home', [App\Http\Controllers\GroupProjectController::class, 'groupDestroy']);
    Route::delete('office/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('office/subtask', [App\Http\Controllers\GroupProjectController::class, 'subDestroy']);
    Route::delete('office/project/team', [App\Http\Controllers\GroupProjectController::class, 'teamDestroy']);
    Route::delete('office/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackDestroy'])->name('office/feedDel');

    // Admin Privilege
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin/user');
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
    Route::post('/admin/user/restore/{id}', [App\Http\Controllers\AdminController::class, 'userRestore'])->name('admin.user.restore');
    Route::post('/admin/group/restore/{id}', [App\Http\Controllers\AdminController::class, 'groupRestore'])->name('admin.group.restore');
    Route::post('/admin/project/restore/{id}', [App\Http\Controllers\AdminController::class, 'projectRestore'])->name('admin.project.restore');
    Route::post('/admin/task/restore/{id}', [App\Http\Controllers\AdminController::class, 'taskRestore'])->name('admin.task.restore');
    Route::post('/admin/team/restore/{id}', [App\Http\Controllers\AdminController::class, 'teamRestore'])->name('admin.team.restore');
    Route::post('/admin/feedback/restore/{id}', [App\Http\Controllers\AdminController::class, 'feedbackRestore'])->name('admin.feedback.restore');
});

// Special Privilege View or the Faculty View
Route::middleware(['auth', 'user-access:faculty'])->group(function () {
    Route::get('/faculty/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('faculty/home');
    Route::get('/faculty/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'projectShow']);
    Route::get('/faculty/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/faculty/project/{id}/task-{id2}', [App\Http\Controllers\GroupProjectController::class, 'subShow']);
    Route::get('/faculty/project/{id}/event', [App\Http\Controllers\GroupProjectController::class, 'eventShow']);
    Route::get('/faculty/project/{id}/progress', [App\Http\Controllers\GroupProjectController::class, 'chartShow']);
    Route::get('/faculty/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);
    
    Route::post('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('faculty/home');
    Route::post('faculty/project', [App\Http\Controllers\GroupProjectController::class, 'projectStore'])->name('faculty/project');
    Route::post('faculty/project/subtask', [App\Http\Controllers\GroupProjectController::class, 'subStore'])->name('faculty/subtask');
    Route::post('faculty/project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('faculty/task');
    Route::post('faculty/project/event', [App\Http\Controllers\GroupProjectController::class, 'eventStore'])->name('faculty/event');
    Route::post('faculty/project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('faculty/team');
    Route::post('faculty/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackStore'])->name('faculty/feedback');

    Route::put('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupUpdate'])->name('faculty/edit');
    Route::put('faculty/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('faculty/detail');
    Route::put('faculty/subtask', [App\Http\Controllers\GroupProjectController::class, 'subUpdate'])->name('faculty/update');
    Route::put('faculty/event', [App\Http\Controllers\GroupProjectController::class, 'eventUpdate'])->name('faculty/eveUp');
    Route::put('faculty/team', [App\Http\Controllers\GroupProjectController::class, 'teamUpdate'])->name('faculty/editTeam');

    Route::delete('faculty/home', [App\Http\Controllers\GroupProjectController::class, 'groupDestroy']);
    Route::delete('faculty/subtask', [App\Http\Controllers\GroupProjectController::class, 'subDestroy']);
    Route::delete('faculty/project/team', [App\Http\Controllers\GroupProjectController::class, 'teamDestroy']);
    Route::delete('faculty/post', [App\Http\Controllers\GroupProjectController::class, 'projectDestroy'])->name('faculty/post');
    Route::delete('faculty/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('faculty/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackDestroy'])->name('faculty/feedDel');
});

// Regular Privilege View or the Student View
Route::middleware(['auth', 'user-access:student'])->group(function () {
    Route::get('/home', [App\Http\Controllers\GroupProjectController::class, 'index'])->name('student/home');
    Route::get('/project/{id}', [App\Http\Controllers\GroupProjectController::class, 'projectShow']);
    Route::get('/project/{id}/task', [App\Http\Controllers\GroupProjectController::class, 'taskShow']);
    Route::get('/project/{id}/task-{id2}', [App\Http\Controllers\GroupProjectController::class, 'subShow']);
    Route::get('/project/{id}/event', [App\Http\Controllers\GroupProjectController::class, 'eventShow']);
    Route::get('/project/{id}/progress', [App\Http\Controllers\GroupProjectController::class, 'chartShow']);
    Route::get('/project/{id}/team', [App\Http\Controllers\GroupProjectController::class, 'teamShow']);

    Route::post('home', [App\Http\Controllers\GroupProjectController::class, 'groupStore'])->name('student/home');
    Route::post('project', [App\Http\Controllers\GroupProjectController::class, 'projectStore'])->name('student/project');
    Route::post('project/subtask', [App\Http\Controllers\GroupProjectController::class, 'subStore'])->name('student/subtask');
    Route::post('project/task', [App\Http\Controllers\GroupProjectController::class, 'taskStore'])->name('student/task');
    Route::post('project/event', [App\Http\Controllers\GroupProjectController::class, 'eventStore'])->name('student/event');
    Route::post('project/team', [App\Http\Controllers\GroupProjectController::class, 'memberStore'])->name('student/team');
    Route::post('feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackStore'])->name('student/feedback');

    Route::put('student/home', [App\Http\Controllers\GroupProjectController::class, 'groupUpdate'])->name('student/edit');
    Route::put('student/task', [App\Http\Controllers\GroupProjectController::class, 'taskUpdate'])->name('student/detail');
    Route::put('student/subtask', [App\Http\Controllers\GroupProjectController::class, 'subUpdate'])->name('student/update');
    Route::put('student/event', [App\Http\Controllers\GroupProjectController::class, 'eventUpdate'])->name('student/eveUp');
    Route::put('student/team', [App\Http\Controllers\GroupProjectController::class, 'teamUpdate'])->name('student/editTeam');

    Route::delete('student/home', [App\Http\Controllers\GroupProjectController::class, 'groupDestroy']);
    Route::delete('student/task', [App\Http\Controllers\GroupProjectController::class, 'taskDestroy']);
    Route::delete('student/subtask', [App\Http\Controllers\GroupProjectController::class, 'subDestroy']);
    Route::delete('student/project/team', [App\Http\Controllers\GroupProjectController::class, 'teamDestroy']);
    Route::delete('student/post', [App\Http\Controllers\GroupProjectController::class, 'projectDestroy'])->name('student/post');
    Route::delete('student/feedback', [App\Http\Controllers\GroupProjectController::class, 'feedbackDestroy'])->name('student/feedDel');
});