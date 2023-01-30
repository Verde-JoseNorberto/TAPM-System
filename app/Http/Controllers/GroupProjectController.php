<?php

namespace App\Http\Controllers;

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

        if (auth()->user()->type == 'faculty') {
            return view('faculty/home', compact(['group_projects', 'projects']));
        }else if (auth()->user()->type == 'client') {
            return view('client/home', compact(['group_projects', 'projects']));
        }else if (auth()->user()->type == 'office') {
            return view('office/home', compact(['group_projects', 'projects']));
        }else{
            return view('student/home', compact(['group_projects', 'projects']));
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
        $add = new GroupProject;
        $add->project_title = $request->project_title;
        $add->project_category = $request->project_category;
        $add->project_phase = $request->project_phase;
        $add->year_term = $request->year_term;
        $add->section = $request->section;
        $add->due_date = $request->due_date;
        $add->team = $request->team;
        $add->advisor = $request->advisor;
        $add->notes = $request->notes;
        $add->save();
        return view('faculty/project')->with('group_projects', $add);
    }

    public function projectStore(Request $request)
    {
        $add = new Project;
        $add->title = $request->title;
        $add->file = $request->file;
        $add->description = $request->description;
        $add->save();
        return view('student/project')->with('projects', $add);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function show(GroupProject $group_projects, Project $projects, $id)
    {
        $group_projects = GroupProject::find($id);
        $projects = Project::find($id);
        
        if (auth()->user()->type == 'faculty') {
            return view('faculty/project', compact(['group_projects', 'projects']));
        }else if (auth()->user()->type == 'client') {
            return view('client/project', compact(['group_projects', 'projects']));
        }else if (auth()->user()->type == 'office') {
            return view('office/project', compact(['group_projects', 'projects']));
        }else{
            return view('student/project', compact(['group_projects', 'projects']));  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupProject $groupProject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupProject $groupProject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupProject $group_projects)
    {
        // $group_projects = GroupProject::find($id);
        // $group_projects->delete();

        // // redirect
        // Session::flash('message', 'Successfully deleted the shark!');
        // return Redirect::to('/');
    }
}
