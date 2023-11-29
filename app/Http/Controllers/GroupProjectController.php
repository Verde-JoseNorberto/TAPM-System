<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Feedback;
use App\Models\GroupProject;
use App\Models\Member;
use App\Models\Project;
use App\Models\Subtask;
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
        $group_projects = GroupProject::with('members.user')
        ->where('user_id', $user->id)
        ->orWhereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id);})->get();

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
            'section'=>'required',
            'team'=>'required',
            'advisor'=>'required',
        ]);

        $group_projects = new GroupProject;
        $group_projects->title = $group['title'];
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
                    $member = new Member();
                    $member->group_project_id = $group_projects->id;
                    $member->user_id = $certainUser->id;
                    $member->save();

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
            'file' => 'sometimes|file',
            'description' => 'required',
            'group_project_id' => 'required',
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $record = $file->getClientOriginalName();
            $name = pathinfo($record, PATHINFO_FILENAME);
            $extension = pathinfo($record, PATHINFO_EXTENSION);
            $fileName = time() . '-' . $name . '.' . $extension;
            $file->move(public_path('files'), $fileName);
        }
    
        $data = [
            'title' => $request->title,
            'file' => isset($fileName) ? $fileName : null,
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
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'priority' => 'required',
            'group_project_id' => 'required',
            'assign_id' => 'required|exists:users,id',
        ]);
    
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        
        $task = Task::create($input);
        $taskCreate = User::find($request->assign_id);
        $taskCreate->notify(new TaskCreated($task->group_project_id, $task->title, auth()->user()->name, $taskCreate->type));

        $calendarEvent = $task->toCalendarEvent();

        return redirect()->back()->with('success', 'Posted Task Successfully.')->with('calendarEvent', $calendarEvent);
    }

    public function subStore(Request $request)
    {   
        $request->validate([
            'title' => [
                'required',
                Rule::unique('subtasks', 'title')->where('task_id', $request->input('task_id'))->whereNull('deleted_at'),
            ],
            'content' => 'required',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'priority' => 'required',
            'task_id' => 'required',
            'assign_id' => 'required|exists:users,id',
        ]);
    
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        
        $subtask = Subtask::create($input);
        $taskCreate = User::find($request->assign_id);
        $taskCreate->notify(new TaskCreated($subtask->group_project_id, $subtask->title, auth()->user()->name, $taskCreate->type));


        return redirect()->back()->with('success', 'Posted Subtask Successfully.');
    }

    public function memberStore(Request $request)
    {
        $request->validate([
            'group_project_id' => 'required',
            'user_id' => 'required',
            'role' => 'required',
        ]);
    
        $user_id = $request->input('user_id');
        $group_project_id = $request->input('group_project_id');
        $role = $request->input('role');
    
        $existingMember = Member::where('user_id', $user_id)
            ->where('group_project_id', $group_project_id)
            ->first();
    
        if ($existingMember) {
            return redirect()->back()->with('error', 'Member is already added to the project.');
        }
    
        Member::create([
            'group_project_id' => $group_project_id,
            'user_id' => $user_id,
            'role' => $role,
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

    public function subShow(GroupProject $group_projects, Task $tasks, Subtask $subtasks, $id, $id2)
    {
        $user = auth()->user();
        $notifications = $user->notifications;
        $group_projects = GroupProject::find($id);
        $tasks = Task::find($id2);
        if (Subtask::all()->where('task_id', $tasks->id)->count() == 0){
            $subtasks = Subtask::all();
        }else{
            $subtasks = Subtask::all()->where('task_id', $tasks->id)
            ->where('status','Finished')->count() / 
            Subtask::all()->where('task_id', $tasks->id)->count() * 100;
        }
        
        if ($group_projects->user_id === auth()->user()->id) {  
            if ($user->type == 'faculty') {
                return view('faculty/detail', compact(['group_projects', 'tasks', 'notifications', 'user', 'subtasks']));
            }else if ($user->type == 'office') {
                return view('office/detail', compact(['group_projects', 'tasks', 'notifications', 'user', 'subtasks']));
            }else{
                return view('student/detail', compact(['group_projects', 'tasks', 'notifications', 'user', 'subtasks']));
            }
        }else{
            $members = $group_projects->members()->where('user_id', $user->id)->first();
            if ($members) {
                if ($user->type == 'faculty') {
                    return view('faculty/detail', compact(['group_projects', 'tasks', 'notifications', 'user', 'subtasks']));
                }else if ($user->type == 'office') {
                    return view('office/detail', compact(['group_projects', 'tasks', 'notifications', 'user', 'subtasks']));
                }else{
                    return view('student/detail', compact(['group_projects', 'tasks', 'notifications', 'user', 'subtasks']));
                }
            } else {
                abort(403, 'Unauthorized');
            }
        }
    }

    public function chartShow(GroupProject $group_projects, $id)
    {   
        $user = auth()->user();
        $notifications = $user->notifications;
        $group_projects = GroupProject::find($id);
        $tasks = $group_projects->tasks;
    
        $totalTasks = $tasks->count();
        $tasksToDo = $tasks->where('status', 'To Do')->count();
        $tasksInProgress = $tasks->where('status', 'In Progress')->count();
        $tasksFinished = $tasks->where('status', 'Finished')->count();
    
        $taskData = [
            $totalTasks > 0 ? ($tasksToDo / $totalTasks * 100) : 0,
            $totalTasks > 0 ? ($tasksInProgress / $totalTasks * 100) : 0,
            $totalTasks > 0 ? ($tasksFinished / $totalTasks * 100) : 0,
        ];
    
        $subtasks = $tasks->flatMap(function ($task) {
            return $task->subtasks;
        });
    
        $totalSubTasks = $subtasks->count();
        $subTasksToDo = $subtasks->where('status', 'To Do')->count();
        $subTasksInProgress = $subtasks->where('status', 'In Progress')->count();
        $subTasksFinished = $subtasks->where('status', 'Finished')->count();
    
        $subtaskData = [
            $totalSubTasks > 0 ? ($subTasksToDo / $totalSubTasks * 100) : 0,
            $totalSubTasks > 0 ? ($subTasksInProgress / $totalSubTasks * 100) : 0,
            $totalSubTasks > 0 ? ($subTasksFinished / $totalSubTasks * 100) : 0,
        ];

        if ($group_projects->user_id === auth()->user()->id) {
            if ($user->type == 'faculty') {
                return view('faculty/chart', compact(['group_projects', 'tasks', 'notifications', 'user']), [
                    'taskData' => $taskData,
                    'subtaskData' => $subtaskData,
                ]);
            } elseif ($user->type == 'office') {
                return view('office/chart', compact(['group_projects', 'tasks', 'notifications', 'user']), [
                    'taskData' => $taskData,
                    'subtaskData' => $subtaskData,
                ]);
            } else {
                return view('student/chart', compact(['group_projects', 'tasks', 'notifications', 'user']), [
                    'taskData' => $taskData,
                    'subtaskData' => $subtaskData,
                ]);
            }
        } else {
            $members = $group_projects->members()->where('user_id', $user->id)->first();
            if ($members) {
                if ($user->type == 'faculty') {
                    return view('faculty/chart', compact(['group_projects', 'tasks', 'notifications', 'user']), [
                        'taskData' => $taskData,
                        'subtaskData' => $subtaskData,
                    ]);
                } elseif ($user->type == 'office') {
                    return view('office/chart', compact(['group_projects', 'tasks', 'notifications', 'user']), [
                        'taskData' => $taskData,
                        'subtaskData' => $subtaskData,
                    ]);
                } else {
                    return view('student/chart', compact(['group_projects', 'tasks', 'notifications', 'user']), [
                        'taskData' => $taskData,
                        'subtaskData' => $subtaskData,
                    ]);
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
            }else{
                return view('student/team', compact(['group_projects', 'users', 'members', 'notifications']));
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
            'section' => 'required',
            'team' => 'required',
            'advisor' => 'required',
        ]);
    
        $id = $request->input('id');
        $group_projects = GroupProject::find($id);
    
        $group_projects->title = $request->input('title');
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
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'priority' => 'required',
            'group_project_id' => 'required',
            'assign_id' => 'required|exists:users,id',
        ]);
    
        $id = $request->input('id');
        $task = Task::find($id);

        $task->title = $request->input('title');
        $task->content = $request->input('content');
        $task->start_date = $request->input('start_date');
        $task->due_date = $request->input('due_date');
        $task->status = $request->input('status');
        $task->priority = $request->input('priority');
        $task->assign_id = $request->input('assign_id');
        $task->updated_by = auth()->user()->id;
        $task->save();

        if ($task->status === 'Finished') {
            $taskCreate = User::find($task->user_id);
            $taskCreate->notify(new TaskCompleted($task->group_project_id, $task->title, auth()->user()->name, $taskCreate->type));
        }
    
        return redirect()->back()->with('success', 'Updated Task Successfully');
    }

    public function subUpdate(Request $request, Subtask $subtasks)
    {
        $request->validate([
            'id' => 'required',
            'title' => [
                'required',
                Rule::unique('subtasks', 'title')->where('task_id', $request->input('task_id'))->ignore($request->input('id'))->whereNull('deleted_at'),
            ],
            'content' => 'required',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'priority' => 'required',
            'task_id' => 'required',
            'assign_id' => 'required|exists:users,id',
        ]);
    
        $id = $request->input('id');
        $subtasks = Subtask::find($id);

        $subtasks->title = $request->input('title');
        $subtasks->content = $request->input('content');
        $subtasks->start_date = $request->input('start_date');
        $subtasks->due_date = $request->input('due_date');
        $subtasks->status = $request->input('status');
        $subtasks->priority = $request->input('priority');
        $subtasks->assign_id = $request->input('assign_id');
        $subtasks->updated_by = auth()->user()->id;
        $subtasks->save();

        if ($subtasks->status === 'Finished') {
            $taskCreate = User::find($subtasks->user_id);
            $taskCreate->notify(new TaskCompleted($subtasks->group_project_id, $subtasks->title, auth()->user()->name, $taskCreate->type));
        }
    
        return redirect()->back()->with('success', 'Updated Subtask Successfully');
    }

    public function teamUpdate(Request $request, Member $members)
    {
        $request->validate([
            'id' => 'required',
            'group_project_id' => 'required',
            'role' => 'required',
        ]);
    
        $id = $request->input('id');
        $members = Member::find($id);
    
        $members->role = $request->input('role');
        $members->save();
    
        return redirect()->back()->with('success', 'Updated Member Successfully');
    }
    
    public function eventShow(GroupProject $group_projects, $id, Request $request)
    {
        $user = auth()->user();
        $notifications = $user->notifications;
        $group_projects = GroupProject::find($id);
        
        if ($request->ajax()) {
            if ($request->type == 'fetch') {
                $event = Event::find($request->id);
    
                return response()->json(['data' => $event]);
            }
    
            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
    
            return response()->json($data);
        }

        if ($group_projects->user_id === auth()->user()->id) {
            if ($user->type == 'faculty') {
                return view('faculty/calendar', compact(['group_projects', 'notifications', 'user']));
            } elseif ($user->type == 'office') {
                return view('office/calendar', compact(['group_projects', 'notifications', 'user']));
            } else {
                return view('student/calendar', compact(['group_projects', 'notifications', 'user'])); 
            }
        } else {
            $members = $group_projects->members()->where('user_id', $user->id)->first();
            if ($members) {
                if ($user->type == 'faculty') {
                    return view('faculty/calendar', compact(['group_projects', 'notifications', 'user']));
                } elseif ($user->type == 'office') {
                    return view('office/calendar', compact(['group_projects', 'notifications', 'user']));
                } else {
                    return view('student/calendar', compact(['group_projects', 'notifications', 'user']));
                }
            } else {
                abort(403, 'Unauthorized');
            }
        }
    }
    
    public function eventStore(Request $request)
    {   
        $request->validate([
            'title' => [
                'required',
                Rule::unique('events', 'title')->where('group_project_id', $request->input('group_project_id'))->whereNull('deleted_at'),
            ],
            'description' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:today',
            'group_project_id' => 'required',
        ]);
    
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        
        Event::create($input);

        return redirect()->back()->with('success', 'Posted Event Successfully.');
    }

    public function eventUpdate(Request $request, Event $events)
    {   
        $request->validate([
            'id' => 'required',
            'title' => [
                'required',
                Rule::unique('events', 'title')->where('group_project_id', $request->input('group_project_id'))->ignore($request->input('id'))->whereNull('deleted_at'),
            ],
            'description' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:today',
            'group_project_id' => 'required',
        ]);

        $id = $request->input('id');
        $events = Event::find($id);
    
        $events->title = $request->input('title');
        $events->description = $request->input('description');
        $events->start = $request->input('start');
        $events->end = $request->input('end');
        $events->save();
        

        return redirect()->back()->with('success', 'Updated Event Successfully.');
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

        $group_projects->delete();

        return redirect()->back()->with('success', 'Deleted Group Successfully');
    }
    public function projectDestroy(Request $request, Project $projects)
    {
        $id = $request->input('id');
        $projects = Project::findOrFail($id);

        $projects->delete();

        return redirect()->back()->with('success', 'Deleted Update Successfully');
    }
    public function taskDestroy(Request $request, Task $tasks)
    {
        $id = $request->input('id');
        $tasks = Task::findOrFail($id);

        $tasks->delete();

        return redirect()->back()->with('success', 'Deleted Task Successfully');
    }
    public function subDestroy(Request $request, Subtask $subtasks)
    {
        $id = $request->input('id');
        $subtasks = Subtask::findOrFail($id);

        $subtasks->delete();

        return redirect()->back()->with('success', 'Deleted Subtask Successfully');
    }
    public function eventDestroy(Request $request, Event $events)
    {
        $id = $request->input('id');
        $events = Event::findOrFail($id);

        $events->delete();

        return redirect()->back()->with('success', 'Removed Event Successfully');
    }
    public function teamDestroy(Request $request, Member $members)
    {
        $id = $request->input('id');
        $members = Member::findOrFail($id);

        $members->delete();

        return redirect()->back()->with('success', 'Removed Member Successfully');
    }
    public function feedbackDestroy(Request $request, Feedback $feedbacks)
    {
        $id = $request->input('id');
        $feedbacks = Feedback::findOrFail($id);

        $feedbacks->delete();

        return redirect()->back()->with('success', 'Deleted Feedback Successfully');
    }
}
