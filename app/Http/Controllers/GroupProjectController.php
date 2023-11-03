<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\GroupProject;
use App\Models\Member;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\FeedbackSent;
use App\Notifications\GroupCreated;
use App\Notifications\MemberAdded;
use App\Notifications\ProjectCreated;
use App\Notifications\TaskCompleted;
use App\Notifications\TaskCreated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
        $user = auth()->user();
        $notifications = $user->notifications;
        $group_projects = GroupProject::where('user_id', $user->id)
        ->orWhereHas('members', function ($query) use ($user) 
        {$query->where('user_id', $user->id);})->get();

        if ($user->type == 'faculty') {
            return view('faculty/home', compact(['group_projects', 'notifications', 'user']));
        }else if ($user->type == 'office') {
            return view('office/home', compact(['group_projects', 'notifications', 'user']));
        }else{
            return view('student/home', compact(['group_projects', 'notifications', 'user']));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function groupStore(Request $request)
    {   
        $group = $request->validate([
            'title' => [
                'required',
                Rule::unique('group_projects', 'title')->whereNull('deleted_at'),
            ],
            'subject'=>'required',
            'section'=>'required',
            'team'=>'required',
            'advisor'=>'required',
        ]);

        $group_projects = new GroupProject;
        $group_projects->title = $group['title'];
        $group_projects->subject = $group['subject'];
        $group_projects->section = $group['section'];
        $group_projects->team = $group['team'];
        $group_projects->advisor = $group['advisor'];
        $group_projects->user_id = auth()->user()->id;
        $group_projects->save();

        $members = new Member();
        $members->group_project_id = $group_projects->id;
        $members->user_id = auth()->user()->id;
        $members->save();
        
        $certainUser = User::find(1);

        if ($certainUser) {
            if ($certainUser->id !== auth()->user()->id) {
                $existingMember = Member::where('user_id', $certainUser->id)
                    ->where('group_project_id', $group_projects->id)
                    ->first();

                if (!$existingMember) {
                    // Add the certain user as a member
                    $member = new Member();
                    $member->group_project_id = $group_projects->id;
                    $member->user_id = $certainUser->id;
                    $member->save();

                    // Notify the certain user
                    $certainUser->notify(new GroupCreated($group_projects->id, $group_projects->title, auth()->user()->name, $certainUser->type));
                }
            }
        }

        return redirect()->back()->with('success', 'Created Group Successfully.');
    }

    public function projectStore(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('projects', 'title')->where('group_project_id', $request->input('group_project_id'))->whereNull('deleted_at'),
            ],
            'file' => 'required',
            'description' => 'required',
            'group_project_id' => 'required',
        ]);

        $file = $request->file('file');
        $record = $file->getClientOriginalName();
        $name = pathinfo($record, PATHINFO_FILENAME);
        $extension = pathinfo($record, PATHINFO_EXTENSION);
        $fileName = time() . '-' . $name . '.' . $extension;
        $file->move(public_path('files'), $fileName);

        $data = [
            'title' => $request->title,
            'file' => $fileName,
            'description' => $request->description,
            'group_project_id' => $request->group_project_id,
            'user_id' => auth()->user()->id,
        ];

        $project = Project::create($data);

        $projectPost = GroupProject::find($request->group_project_id);
        $members = $projectPost->users;

        $membersToNotify = $members->filter(function ($member) use ($request) {
            return $member->id !== auth()->user()->id;
        });

        foreach ($membersToNotify as $member) {
            $member->notify(new ProjectCreated($project->group_project_id, auth()->user()->name, $projectPost->title, $member->type));
        }

        return redirect()->back()->with('success', 'Posted Project Successfully.');
    }


    public function taskStore(Request $request)
    {   
        $request->validate([
            'title' => [
                'required',
                Rule::unique('tasks', 'title')->where('group_project_id', $request->input('group_project_id'))->whereNull('deleted_at'),
            ],
            'content' => 'required',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'group_project_id' => 'required',
            'assign_id' => 'required|exists:users,id',
        ]);
    
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        
        $task = Task::create($input);
        $taskCreate = User::find($request->assign_id);
        $taskCreate->notify(new TaskCreated($task->group_project_id, $task->title, auth()->user()->name, $taskCreate->type));

        return redirect()->back()->with('success', 'Posted Task Successfully.');
    }

    public function memberStore(Request $request)
    {   
        $request->validate([
            'group_project_id' => 'required',
            'user_id' => 'required',
        ]);
    
        $user_id = $request->input('user_id');
        $group_project_id = $request->input('group_project_id');
    
        $existingMember = Member::where('user_id', $user_id)
            ->where('group_project_id', $group_project_id)
            ->first();
    
        if ($existingMember) {
            return redirect()->back()->with('error', 'Member is already added to the project.');
        }
    
        Member::create([
            'group_project_id' => $group_project_id,
            'user_id' => $user_id,
        ]);

        $group_projects = GroupProject::find($group_project_id);
        
        $memberAdd = User::find($request->user_id);
        $memberAdd->notify(new MemberAdded($group_project_id, $group_projects->title, $memberAdd->type));
        
        return redirect()->back()->with('success', 'Member Added Successfully.');
    }

    public function feedbackStore(Request $request)
    {
        $request->validate([
            'comment'=>'required',
            'project_id'=>'required' 

        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        $feedback = Feedback::create($input);

        $projectPost = Project::find($request->project_id);
        $members = $projectPost->users;

        $membersToNotify = $members->filter(function ($member) use ($request) {
            return $member->id !== auth()->user()->id;
        });

        foreach ($membersToNotify as $member) {
            $member->notify(new FeedbackSent($feedback->project->group_project_id, auth()->user()->name, $projectPost->title, $member->type));
        }

        return redirect()->back()->with('success', 'Feedback Posted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function projectShow(Request $request, GroupProject $group_projects, Project $projects, Task $tasks, Feedback $feedbacks, $id)
    {
        $user = auth()->user();
        $notifications = $user->notifications;
        $group_projects = GroupProject::find($id);
        $projects = Project::all();
        $feedbacks = Feedback::all();

        if (Task::all()->where('group_project_id', $group_projects->id)->count() == 0){
            $tasks = Task::all();
        }else{
            $tasks = Task::all()->where('group_project_id', $group_projects->id)
            ->where('status','Finished')->count() / 
            Task::all()->where('group_project_id', $group_projects->id)->count() * 100;
        }
        
        if ($group_projects->user_id === auth()->user()->id) {  
            if ($user->type == 'faculty') {
                return view('faculty/project', compact(['group_projects', 'tasks', 'notifications', 'user']));
            }else if ($user->type == 'office') {
                return view('office/project', compact(['group_projects', 'tasks', 'notifications', 'user']));
            }else{
                return view('student/project', compact(['group_projects', 'tasks', 'notifications', 'user']));
            }
        }else{
            $members = $group_projects->members()->where('user_id', $user->id)->first();
            if ($members) {
                if ($user->type == 'faculty') {
                    return view('faculty/project', compact(['group_projects', 'tasks', 'notifications', 'user']));
                }else if ($user->type == 'office') {
                    return view('office/project', compact(['group_projects', 'tasks', 'notifications', 'user']));
                }else{
                    return view('student/project', compact(['group_projects', 'tasks', 'notifications', 'user']));
                }
            } else {
                abort(403, 'Unauthorized');
            }
        }

        
    }
    
    public function taskShow(GroupProject $group_projects, Task $tasks, $id)
    {
        $user = auth()->user();
        $notifications = $user->notifications;
        $group_projects = GroupProject::find($id);

        if (Task::all()->where('group_project_id', $group_projects->id)->count() == 0){
            $tasks = Task::all();
        }else{
            $tasks = Task::all()->where('group_project_id', $group_projects->id)
            ->where('status','Finished')->count() / 
            Task::all()->where('group_project_id', $group_projects->id)->count() * 100;
        }
        
        if ($group_projects->user_id === auth()->user()->id) {  
            if ($user->type == 'faculty') {
                return view('faculty/task', compact(['group_projects', 'tasks', 'notifications', 'user']));
            }else if ($user->type == 'office') {
                return view('office/task', compact(['group_projects', 'tasks', 'notifications', 'user']));
            }else{
                return view('student/task', compact(['group_projects', 'tasks', 'notifications', 'user']));
            }
        }else{
            $members = $group_projects->members()->where('user_id', $user->id)->first();
            if ($members) {
                if ($user->type == 'faculty') {
                    return view('faculty/task', compact(['group_projects', 'tasks', 'notifications', 'user']));
                }else if ($user->type == 'office') {
                    return view('office/task', compact(['group_projects', 'tasks', 'notifications', 'user']));
                }else{
                    return view('student/task', compact(['group_projects', 'tasks', 'notifications', 'user']));
                }
            } else {
                abort(403, 'Unauthorized');
            }
        }

    }

    public function teamShow(GroupProject $group_projects, User $users, Member $members, $id)
    {
        $notifications = auth()->user()->notifications;
        $group_projects = GroupProject::findOrFail($id);        
        $users = User::all();
        $members = Member::all()->where('group_project_id', $group_projects->id);

        if ($group_projects->user_id === auth()->user()->id) {  
            if (auth()->user()->type == 'faculty') {
                return view('faculty/team', compact(['group_projects', 'users', 'members', 'notifications']));
            }else if (auth()->user()->type == 'office') {
                return view('office/team', compact(['group_projects', 'users', 'members', 'notifications']));
            }
        }else{
            $user = auth()->user();
            $member = $group_projects->members()->where('user_id', $user->id)->first();
            if ($member) {
                if (auth()->user()->type == 'faculty') {
                    return view('faculty/team', compact(['group_projects', 'users', 'members', 'notifications']));
                }else if (auth()->user()->type == 'office') {
                    return view('office/team', compact(['group_projects', 'users', 'members', 'notifications']));
                }else{
                    return view('student/team', compact(['group_projects', 'users', 'members', 'notifications']));
                }
            } else {
                abort(403, 'Unauthorized');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function groupUpdate(Request $request, GroupProject $group_projects)
    {
        $request->validate([
            'id' => 'required',
            'title' => [
                'required',
                Rule::unique('group_projects', 'title')
                    ->where(function ($query) use ($request) {
                        return $query->where('user_id', auth()->user()->id)
                            ->whereNull('deleted_at')
                            ->where('id', '<>', $request->input('id'));
                    }),
            ],
            'subject' => 'required',
            'section' => 'required',
            'team' => 'required',
            'advisor' => 'required',
        ]);
    
        $id = $request->input('id');
        $group_projects = GroupProject::find($id);
    
        $group_projects->title = $request->input('title');
        $group_projects->subject = $request->input('subject');
        $group_projects->section = $request->input('section');
        $group_projects->team = $request->input('team');
        $group_projects->advisor = $request->input('advisor');
        $group_projects->save();
    
        return redirect()->back()->with('success', 'Updated Group Successfully');
    }
    public function taskUpdate(Request $request, Task $tasks)
    {
        $request->validate([
            'id' => 'required',
            'title' => [
                'required',
                Rule::unique('tasks', 'title')->where('group_project_id', $request->input('group_project_id'))->ignore($request->input('id'))->whereNull('deleted_at'),
            ],
            'content' => 'required',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'group_project_id' => 'required',
            'assign_id' => 'required|exists:users,id',
        ]);
    
        $id = $request->input('id');
        $task = Task::find($id);

        $task->title = $request->input('title');
        $task->content = $request->input('content');
        $task->due_date = $request->input('due_date');
        $task->status = $request->input('status');
        $task->assign_id = $request->input('assign_id');
        $task->updated_by = auth()->user()->id;
        $task->save();

        if ($task->status === 'Finished') {
            $taskCreate = User::find($task->user_id);
            $taskCreate->notify(new TaskCompleted($task->group_project_id, $task->title, auth()->user()->name, $taskCreate->type));
        }
    
        return redirect()->back()->with('success', 'Updated Task Successfully');
    }

    public function calendar()
    {
        // Retrieve task data with due dates
        $tasks = Task::whereNotNull('due_date')->get();

        // Format the task data for FullCalendar
        $events = [];
        foreach ($tasks as $task) {
            $events[] = [
                'title' => $task->title,
                'start' => $task->due_date,
                'end' => $task->due_date,
            ];
        }

        return view('office/calendar', compact('events'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function groupDestroy(Request $request, GroupProject $group_projects)
    {
        $id = $request->input('id');
        $group_projects = GroupProject::findOrFail($id);

        GroupProject::find($id)->delete();

        $group_projects->delete();

        return redirect()->back()->with('success', 'Deleted Group Successfully');
    }
    public function projectDestroy(Request $request, Project $projects)
    {
        $id = $request->input('id');
        $projects = Project::findOrFail($id);

        Project::find($id)->delete();

        $projects->delete();

        return redirect()->back()->with('success', 'Deleted Update Successfully');
    }
    public function taskDestroy(Request $request, Task $tasks)
    {
        $id = $request->input('id');
        $tasks = Task::findOrFail($id);

        Task::find($id)->delete();

        $tasks->delete();

        return redirect()->back()->with('success', 'Deleted Task Successfully');
    }
    public function teamDestroy(Request $request, Member $members)
    {
        $id = $request->input('id');
        $members = Member::findOrFail($id);

        Member::find($id)->delete();

        $members->delete();

        return redirect()->back()->with('success', 'Removed Member Successfully');
    }
    public function feedbackDestroy(Request $request, Feedback $feedbacks)
    {
        $id = $request->input('id');
        $feedbacks = Feedback::findOrFail($id);

        Feedback::find($id)->delete();

        $feedbacks->delete();

        return redirect()->back()->with('success', 'Deleted Feedback Successfully');
    }
}
