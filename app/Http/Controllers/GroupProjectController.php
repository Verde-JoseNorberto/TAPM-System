<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\GroupProject;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        return view('office.admin');
    }
    public function index()
    {
        $group_projects = GroupProject::all();
        $projects = Project::all();
        $tasks = Task::all();
        $feedbacks = Feedback::all();

        if (auth()->user()->type == 'faculty') {
            return view('faculty/home', compact(['group_projects']));
            return view('faculty/project', compact(['group_projects', 'projects', 'tasks', 'feedbacks']));
            return view('faculty/task', compact(['group_projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/home', compact(['group_projects']));
            return view('office/project', compact(['group_projects', 'projects', 'tasks', 'feedbacks']));
            return view('office/task', compact(['group_projects', 'tasks']));
        }else{
            return view('student/home', compact(['group_projects']));
            return view('student/project', compact(['group_projects', 'projects', 'tasks', 'feedbacks']));
            return view('student/task', compact(['group_projects', 'tasks']));
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
        $request->validate([
            'title'=>'required',
            'subject'=>'required',
            'section'=>'required',
            'team'=>'required',
            'advisor'=>'required',
        ]);

        GroupProject::create($request->all());
        return redirect()->back()->with('success', 'Created Project Successfully.');
    }

    public function projectStore(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'file'=>'required',
            'description'=>'required',
            'group_project_id'=>'required'
        ]);

        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('files'), $fileName);

        $data = array(
            'title'=>$request->title,
            'file'=>$fileName,
            'description'=>$request->description,
            'group_project_id'=>$request->group_project_id
        );
        $data['user_id'] = auth()->user()->id;
        
        Project::create($data);
        return redirect()->back()->with('success', 'Posted Project Successfully.');
    }

    public function taskStore(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'due_date'=>'required',
            'status'=>'required',
            'group_project_id'=>'required'
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        Task::create($input);
        return redirect()->back()->with('success', 'Posted Task Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function show(GroupProject $group_projects, Project $projects, Task $tasks, Feedback $feedbacks, $id)
    {
        $group_projects = GroupProject::find($id);
        $projects = Project::all();
        $tasks = Task::all();
        $feedbacks = Feedback::all();

        if (auth()->user()->type == 'faculty') {
            return view('faculty/project', compact(['group_projects', 'projects', 'tasks', 'feedbacks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/project', compact(['group_projects', 'projects', 'tasks', 'feedbacks']));
        }else{
            return view('student/project', compact(['group_projects', 'projects', 'tasks', 'feedbacks']));
        }
    }
    
    public function taskShow(GroupProject $group_projects, Task $tasks, $id)
    {
        $group_projects = GroupProject::find($id);
        $tasks = Task::all();
        
        if (auth()->user()->type == 'faculty') {
            return view('faculty/task', compact(['group_projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/task', compact(['group_projects', 'tasks']));
        }else{
            return view('student/task', compact(['group_projects', 'tasks']));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupProject $group_projects, $id)
    {
        $group_projects = GroupProject::find($id);
        
        return view('faculty/edit', compact(['group_projects']));
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
            'id'=>'required',
            'title'=>'required',
            'subject'=>'required',
            'section'=>'required',
            'team'=>'required',
            'advisor'=>'required'
        ]);

        $id = $request->input('id');
        $group_projects = GroupProject::find($id);
        $group_projects->title = $request->input('title');
        $group_projects->subject = $request->input('subject');
        $group_projects->section = $request->input('section');
        $group_projects->team = $request->input('team');
        $group_projects->advisor = $request->input('advisor');
        $group_projects->save();

        return redirect()->back()->with('success', 'Updated Project Successfully');
    }
    public function taskUpdate(Request $request, Task $tasks)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'due_date'=>'required',
            'status'=>'required',
        ]);

        $tasks->save($request->all());
        return redirect()->route('faculty/home')->with('success', 'Updated Project Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function groupDestroy(GroupProject $group_projects, $id)
    {
        $group_projects = GroupProject::find($id);
        $group_projects->delete();

        return redirect()->back()->with('success', 'Deleted Project Successfully');
    }
    public function projectDestroy(Project $projects, $id)
    {
        $projects = Project::find($id);
        $projects->delete();

        return redirect()->back()->with('success', 'Deleted Update Successfully');
    }
    public function taskDestroy(Task $tasks, $id)
    {
        $tasks = Tasks::find($id);
        $tasks->delete();

        return redirect()->back()->with('success', 'Deleted Task Successfully');
    }
}
