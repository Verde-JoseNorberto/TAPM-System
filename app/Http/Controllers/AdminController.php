<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\User;
use App\Models\Member;
use App\Models\Task;
use App\Models\Project;
use App\Models\GroupProject;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin/user');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'type' => 'required',
        ], [
            'email.unique' => 'The email address is already in use.',
        ]);
    
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type,
        ];
    
        User::create($input);
        return redirect()->back()->with('success', 'New User Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userShow(User $users, Request $request)
    {
        if ($request->get('status') == 'archived') {
            $users = User::onlyTrashed()->get();
        } else {
            $users = User::withTrashed()->get();
        }

        return view('admin/user', compact(['users']));
    }
    public function groupShow(GroupProject $group_projects, Request $request)
    {
        if ($request->get('status') == 'archived') {
            $group_projects = GroupProject::onlyTrashed()->get();
        } else {
            $group_projects = GroupProject::withTrashed()->get();
        }
    
        return view('admin/group', compact(['group_projects']));
    }
    public function taskShow(Task $tasks, Request $request)
    {
        if ($request->get('status') == 'archived') {
            $tasks = Task::onlyTrashed()->get();
        } else {
            $tasks = Task::withTrashed()->get();
        }
    
        return view('admin/task', compact(['tasks']));
    }
    public function chartShow(Subtask $subtasks, Task $tasks, Request $request)
    {
        $group_projects = GroupProject::all();
        $taskData = [];
        $subtaskData = [];
    
        if ($request->get('status') == 'archived') {
            $tasks = Task::onlyTrashed()->get();
            $subtasks = Subtask::onlyTrashed()->get();
        } else {
            $tasks = Task::withTrashed()->get();
            $subtasks = Subtask::withTrashed()->get();
        }
    
        foreach ($group_projects as $group_project) {
            $tasksInProject = $tasks->where('group_project_id', $group_project->id);
    
            $totalTasks = $tasksInProject->count();
            $tasksToDo = $tasksInProject->where('status', 'To Do')->count();
            $tasksInProgress = $tasksInProject->where('status', 'In Progress')->count();
            $tasksFinished = $tasksInProject->where('status', 'Finished')->count();
    
            $taskData[$group_project->id] = [
                $totalTasks > 0 ? ($tasksToDo / $totalTasks * 100) : 0,
                $totalTasks > 0 ? ($tasksInProgress / $totalTasks * 100) : 0,
                $totalTasks > 0 ? ($tasksFinished / $totalTasks * 100) : 0,
            ];
    
            $subtasksInProject = $subtasks->whereIn('task_id', $tasksInProject->pluck('id'));
    
            $totalSubTasks = $subtasksInProject->count();
            $subTasksToDo = $subtasksInProject->where('status', 'To Do')->count();
            $subTasksInProgress = $subtasksInProject->where('status', 'In Progress')->count();
            $subTasksFinished = $subtasksInProject->where('status', 'Finished')->count();
    
            $subtaskData[$group_project->id] = [
                $totalSubTasks > 0 ? ($subTasksToDo / $totalSubTasks * 100) : 0,
                $totalSubTasks > 0 ? ($subTasksInProgress / $totalSubTasks * 100) : 0,
                $totalSubTasks > 0 ? ($subTasksFinished / $totalSubTasks * 100) : 0,
            ];
        }
    
        return view('admin/chart', compact(['group_projects', 'tasks', 'subtasks', 'taskData', 'subtaskData']));
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request, User $users)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'type'=>'required',
        ]);

        $id = $request->input('id');
        $users = User::find($id);
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = bcrypt($request->input('password'));
        $users->type = $request->input('type');
        $users->save();

        return redirect()->back()->with('success', 'Updated User Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDestroy(Request $request, User $users)
    {
        $id = $request->input('id');
        $users = User::withTrashed()->find($id);

        if ($users) {
            $users->delete();
            return redirect()->back()->with('success', 'Deleted User Successfully');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    public function groupDestroy(Request $request, GroupProject $group_projects)
    {
        $id = $request->input('id');
        $group_projects = GroupProject::withTrashed()->find($id);

        if ($group_projects) {
            $group_projects->delete();
            return redirect()->back()->with('success', 'Deleted Group Project Successfully');
        } else {
            return redirect()->back()->with('error', 'Group Project not found.');
        }
    }
    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function taskDestroy(Request $request, Task $tasks)
    {
        $id = $request->input('id');
        $tasks = Task::withTrashed()->find($id);

        if ($tasks) {
            $tasks->delete();
            return redirect()->back()->with('success', 'Deleted Task Successfully');
        } else {
            return redirect()->back()->with('error', 'Task not found.');
        }
    }
    public function subtaskDestroy(Request $request, Subtask $subtask)
    {
        $id = $request->input('id');
        $subtask = Subtask::withTrashed()->find($id);

        if ($subtask) {
            $subtask->delete();
            return redirect()->back()->with('success', 'Deleted Subtask Successfully');
        } else {
            return redirect()->back()->with('error', 'Subtask not found.');
        }
    }
    /**
     * Remove the specified team member from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamDestroy(Request $request, Member $members)
    {
        $id = $request->input('id');
        $members = Member::withTrashed()->find($id);

        if ($members) {
            $members->delete();
            return redirect()->back()->with('success', 'Removed Member Successfully');
        } else {
            return redirect()->back()->with('error', 'Member not found.');
        }
    }
    /**
     * 
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function userRestore(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        if ($user) {
            $user->restore(); // Restore the soft-deleted user
            return redirect()->back()->with('success', 'User restored successfully.');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    public function groupRestore(Request $request, $id)
    {
        $group_project = GroupProject::withTrashed()->find($id);

        if ($group_project) {
            $group_project->restore(); // Restore the soft-deleted group project
            return redirect()->back()->with('success', 'Group Project restored successfully.');
        } else {
            return redirect()->back()->with('error', 'Group Project not found.');
        }
    }
    public function taskRestore(Request $request, $id)
    {
        $task = Task::withTrashed()->find($id);

        if ($task) {
            $task->restore(); // Restore the soft-deleted task
            return redirect()->back()->with('success', 'Task restored successfully.');
        } else {
            return redirect()->back()->with('error', 'Task not found.');
        }
    }
    public function subtaskRestore(Request $request, $id)
    {
        $subtask = Subtask::withTrashed()->find($id);

        if ($subtask) {
            $subtask->restore(); // Restore the soft-deleted subtask
            return redirect()->back()->with('success', 'Subtask restored successfully.');
        } else {
            return redirect()->back()->with('error', 'Subtask not found.');
        }
    }
    public function teamRestore(Request $request, $id)
    {
        $member = Member::withTrashed()->find($id);

        if ($member) {
            $member->restore(); // Restore the soft-deleted team member
            return redirect()->back()->with('success', 'Member restored successfully.');
        } else {
            return redirect()->back()->with('error', 'Member not found.');
        }
    }
}
