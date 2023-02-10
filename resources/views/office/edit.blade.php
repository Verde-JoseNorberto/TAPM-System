@extends('layout.layDir')

@section('page-content')
<div class="container my-4">
  <div class="row-cols-md-2 d-flex justify-content-center">
    <div class="card">
      <div class="card-header">
        {{ __('Edit Project') }}
      </div>
      <div class="card-body">
        <form method="PATCH" action="{{ route('office/home') }}">
          @csrf
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Project Title') }}</label>
                  <input id="project_title" type="text" class="form-control" name="project_title" value="{{ $group_projects->project_title }}">
                </div>
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Project Category') }}</label>
                  <input id="project_category" type="text" class="form-control" name="project_category" value="{{ $group_projects->project_category }}">
                </div>
              </div>
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Subject') }}</label>
                  <input id="subject" type="text" class="form-control" name="subject" value="{{ $group_projects->project_phase }}">
                </div>
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Year & Term') }}</label>
                  <input id="year_term" type="text" class="form-control" name="year_term" value="{{ $group_projects->year_term }}">
                </div>
              </div>
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Section') }}</label>
                  <input id="section" type="text" class="form-control" name="section" value="{{ $group_projects->section }}">
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
            <div class="text-end">
              <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
              <a href="{{ URL::to('faculty/home') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection