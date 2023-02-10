<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\GroupProject;
use Illuminate\Http\Request;

class GroupProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group_projects = GroupProject::all();
        $projects = Project::all();
        $tasks = Task::all();

        if (auth()->user()->type == 'faculty') {
            return view('faculty/home', compact(['group_projects']));
            return view('faculty/project', compact(['group_projects', 'projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/home', compact(['group_projects']));
            return view('office/project', compact(['group_projects', 'projects', 'tasks']));
        }else{
            return view('student/home', compact(['group_projects']));
            return view('student/project', compact(['group_projects', 'projects', 'tasks']));
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
            'project_title'=>'required',
            'project_category'=>'required',
            'subject'=>'required',
            'year_term'=>'required',
            'section'=>'required',
            'team'=>'required',
            'advisor'=>'required',
        ]);

        GroupProject::create($request->all());
        return redirect()->route('faculty/home')->with('success', 'Created Project Successfully.');
    }

    public function projectStore(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'file'=>'required',
            'description'=>'required',
        ]);

        Project::create($request->all());
        return redirect()->route('student/project')->with('success', 'Posted Project Successfully.');
    }

    public function taskStore(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'due_date'=>'required',
        ]);

        Task::create($request->all());
        return redirect()->route('student/task')->with('success', 'Posted Project Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function show(GroupProject $group_projects, Project $projects, Task $tasks, $id)
    {
        $group_projects = GroupProject::find($id);
        $projects = Project::find($id);
        $tasks = Task::find($id);
        
        if (auth()->user()->type == 'faculty') {
            return view('faculty/project', compact(['group_projects', 'projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/project', compact(['group_projects', 'projects', 'tasks']));
        }else{
            return view('student/project', compact(['group_projects', 'projects', 'tasks']));
        }
    }

    public function taskShow(GroupProject $group_projects, Project $projects, Task $tasks, $id)
    {
        $tasks = Task::find($id);
        
        if (auth()->user()->type == 'faculty') {
            return view('faculty/task', compact(['group_projects', 'projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/task', compact(['group_projects', 'projects', 'tasks']));
        }else{
            return view('student/task', compact(['group_projects', 'projects', 'tasks']));
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
    public function update(Request $request, GroupProject $group_projects)
    {
        $group_projects = GroupProject::find($id);

        $request->validate([
            'project_title'=>'required',
            'project_category'=>'required',
            'project_phase'=>'required',
            'year_term'=>'required',
            'section'=>'required',
            'team'=>'required',
            'advisor'=>'required'
        ]);
        
        $group_projects->update($request->all());

        return view('faculty/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupProject $group_projects, Project $projects, Task $tasks, $id)
    {
        $group_projects = GroupProject::find($id);
        $group_projects->delete();

        return redirect()->route('faculty.home');

        $projects = Project::find($id);
        $projects->delete();

        return redirect()->route('student.project');

        $tasks = Tasks::find($id);
        $tasks->delete();

        return redirect()->route('student.project');
    }
}
