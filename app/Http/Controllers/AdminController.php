<?php

namespace App\Http\Controllers;

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
    public function projectShow(Project $projects, GroupProject $group_projects, Request $request)
    {   
        if ($request->get('status') == 'archived') {
            $projects = Project::onlyTrashed()->get();
        } else {
            $projects = Project::withTrashed()->get();
        }

        return view('admin/project', compact(['group_projects', 'projects']));
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
    public function teamShow(Member $members, Request $request)
    {
        if ($request->get('status') == 'archived') {
            $members = Member::onlyTrashed()->get();
        } else {
            $members = Member::withTrashed()->get();
        }
    
        return view('admin/team', compact(['members']));
    }
    public function feedbackShow(Feedback $feedbacks, Request $request)
    {
        if ($request->get('status') == 'archived') {
            $feedbacks = Feedback::onlyTrashed()->get();
        } else {
            $feedbacks = Feedback::withTrashed()->get();
        }
    
        return view('admin/feedback', compact(['feedbacks']));
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
     * Remove the specified project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function projectDestroy(Request $request, Project $projects)
    {
        $id = $request->input('id');
        $projects = Project::withTrashed()->find($id);

        if ($projects) {
            $projects->delete();
            return redirect()->back()->with('success', 'Deleted Project Successfully');
        } else {
            return redirect()->back()->with('error', 'Project not found.');
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
     * Remove the specified feedback from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function feedbackDestroy(Request $request, Feedback $feedbacks)
    {
        $id = $request->input('id');
        $feedbacks = Feedback::withTrashed()->find($id);

        if ($feedbacks) {
            $feedbacks->delete();
            return redirect()->back()->with('success', 'Deleted Feedback Successfully');
        } else {
            return redirect()->back()->with('error', 'Feedback not found.');
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
    public function projectRestore(Request $request, $id)
    {
        $project = Project::withTrashed()->find($id);

        if ($project) {
            $project->restore(); // Restore the soft-deleted project
            return redirect()->back()->with('success', 'Project restored successfully.');
        } else {
            return redirect()->back()->with('error', 'Project not found.');
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
    public function feedbackRestore(Request $request, $id)
    {
        $feedback = Feedback::withTrashed()->find($id);

        if ($feedback) {
            $feedback->restore(); // Restore the soft-deleted feedback
            return redirect()->back()->with('success', 'Feedback restored successfully.');
        } else {
            return redirect()->back()->with('error', 'Feedback not found.');
        }
    }

}
