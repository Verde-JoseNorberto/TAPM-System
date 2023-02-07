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
        }else if (auth()->user()->type == 'client') {
            return view('client/home', compact(['group_projects']));
            return view('client/project', compact(['group_projects', 'projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/home', compact(['group_projects']));
            return view('office/project', compact(['group_projects', 'projects', 'tasks']));
        }else{
            return view('student/home', compact(['group_projects']));
            return view('student/project', compact(['group_projects', 'projects', 'tasks']));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'project_phase'=>'required',
            'year_term'=>'required',
            'section'=>'required',
            'due_date'=>'required',
            'team'=>'required',
            'advisor'=>'required',
        ]);

        $add = new GroupProject;
        $add->project_title = $request->project_title;
        $add->project_category = $request->project_category;
        $add->project_phase = $request->project_phase;
        $add->year_term = $request->year_term;
        $add->section = $request->section;
        $add->due_date = $request->due_date;
        $add->team = $request->team;
        $add->advisor = $request->advisor;
        $add->save();
        return view('faculty/project')->with('group_projects', $add);
    }

    public function projectStore(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'file'=>'required',
            'description'=>'required',
        ]);

        $post = new Project;
        $post->title = $request->title;
        $post->file = $request->file;
        $post->description = $request->description;
        $post->save();
        return view('student/project')->with('projects', $add);
    }

    public function taskStore(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'due_date'=>'required',
        ]);

        $tell = new Task;
        $tell->title = $request->title;
        $tell->content = $request->content;
        $tell->due_date = $request->due_date;
        $tell->save();
        return view('student/project')->with('tasks', $add);
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
        }else if (auth()->user()->type == 'client') {
            return view('client/project', compact(['group_projects', 'projects', 'tasks']));
        }else if (auth()->user()->type == 'office') {
            return view('office/project', compact(['group_projects', 'projects', 'tasks']));
        }else{
            return view('student/project', compact(['group_projects', 'projects', 'tasks']));
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
    public function update(Request $request, GroupProject $group_projects, $id)
    {
        $group_projects = GroupProject::find($id);

        $request->validate([
            'project_title'=>'required',
            'project_category'=>'required',
            'project_phase'=>'required',
            'year_term'=>'required',
            'section'=>'required',
            'due_date'=>'required',
            'team'=>'required',
            'advisor'=>'required'
        ]);
        
        $group_projects = GroupProject::find($id);

        $group_projects->project_title = $request->project_title;
        $group_projects->project_category = $request->project_category;
        $group_projects->project_phase = $request->project_phase;
        $group_projects->year_term = $request->year_term;
        $group_projects->section = $request->section;
        $group_projects->due_date = $request->due_date;
        $group_projects->team = $request->team;
        $group_projects->advisor = $request->advisor;
        $group_projects->save();
        return view('faculty/project')->with('group_projects', $group_projects);
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

        return Redirect::to('/');

        $projects = Project::find($id);
        $projects->delete();

        return Redirect::to('/project/{id}');

        $tasks = Tasks::find($id);
        $tasks->delete();

        return Redirect::to('/project/{id}');
    }
}
