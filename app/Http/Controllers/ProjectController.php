<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        if (auth()->user()->type == 'faculty') {
            return view('faculty/project', compact('projects'));
        }else if (auth()->user()->type == 'client') {
            return view('client/project', compact('projects'));
        }else if (auth()->user()->type == 'office') {
            return view('office/project', compact('projects'));
        }else{
            return view('student/project', compact('projects'));
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
    public function store(Request $request)
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $projects, $id)
    {
        $projects = Project::find($id);
        if (auth()->user()->type == 'faculty') {
            return view('faculty/project', compact('projects'));
        }else if (auth()->user()->type == 'client') {
            return view('client/project', compact('projects'));
        }else if (auth()->user()->type == 'office') {
            return view('office/project', compact('projects'));
        }else{
            return view('student/project', compact('projects'));  
        }   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $projects)
    {
        //
    }
}
