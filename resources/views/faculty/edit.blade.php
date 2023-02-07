@extends('layout.layFac')
@section('page-content')
<div class="container my-4">
  <form method="PUT" action="{{ route('faculty/project') }}">
      @csrf
      <div class="row mb-4">
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Project Title') }}</label>
              <input id="project_title" type="text" class="form-control" name="project_title" value="{{ $group_projects->project_title }}">
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Project Category') }}</label>
              <input id="project_category" type="text" class="form-control" name="project_category" value="{{ $group_projects->project_category }}">
            </div>
          </div>
        </div>
        
        <div class="row mb-4">
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Progress Phase') }}</label>
              <input id="project_phase" type="text" class="form-control" name="project_phase" value="{{ $group_projects->project_phase }}">
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Year & Term') }}</label>
              <input id="year_term" type="text" class="form-control" name="year_term" value="{{ $group_projects->year_term }}">
            </div>
          </div>
        </div>
        
        <div class="row mb-4">
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Section') }}</label>
              <input id="section" type="text" class="form-control" name="section" value="{{ $group_projects->section }}">
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Due Date') }}</label>
              <input id="due_date" type="date" class="form-control" name="due_date" value="{{ $group_projects->due_date }}">
            </div>
          </div>
        </div>
        
        <div class="row mb-4">
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Team') }}</label>
              <input id="team" type="text" class="form-control" name="team" value="{{ $group_projects->team }}">
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
              <label class="form-label">{{ __('Advisor') }}</label>
              <input id="advisor" type="text" class="form-control" name="advisor" value="{{ $group_projects->advisor }}">
            </div>
          </div>
        </div>
  </form>
</div>
@endsection