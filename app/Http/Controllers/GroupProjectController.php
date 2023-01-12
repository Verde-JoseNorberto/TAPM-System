<?php

namespace App\Http\Controllers;

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
        return view('faculty/project');
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
        return redirect('faculty/project')->with('status', 'Project is Made');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function show(GroupProject $groupProject)
    {
        //
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
    public function destroy(GroupProject $groupProject)
    {
        //
    }
}
