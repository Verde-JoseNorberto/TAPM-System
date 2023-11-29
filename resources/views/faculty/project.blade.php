@extends('layout.layFac')

@section('page-content')
<div class="container my-2">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active">{{ __('Project') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/event') }}">{{ __('Events') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/progress') }}">{{ __('Progress') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
    </li>
  </ul>
  <div class="card text-dark border-dark my-3">
      <div class="card-body">
        <h2>{{ $group_projects->title }}</h2>
        <strong>{{ __('Team:') }}</strong> {{ $group_projects->team }}<br>
        <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
        <button class="btn btn-dark position-absolute top-0 end-0 my-3 mx-3" data-bs-toggle="modal" data-bs-target="#updateModal">
          {{ __('Add Updates') }}</button>
      </div>
  </div>

  <div class="card text-dark border-dark my-3">
    <div class="card-body">
      <div class="progress">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
        aria-valuenow="{{ $tasks }}" style="width: {{ $tasks }}%" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>
  </div>
  
  <div class="row row-cols-1 row-cols-md-2 g-4 my-2">
    @include('faculty.post', ['projects' => $group_projects->projects, 'group_project_id' => $group_projects->id])
  </div>

  {{-- Add Project --}}
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('Add Project')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('faculty/project') }}" enctype="multipart/form-data">
            @csrf 
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Title') }}</label>
                  <input id="title" type="text" class="form-control" name="title">
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Description') }}</label>
                  <textarea id="description" class="form-control" rows="4" name="description"></textarea>
                </div>
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('File (Optional)') }}</label>
                  <input id="file" type="file" class="form-control" name="file">
                </div>
              </div>
            </div>

            <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">{{ __('Create Project') }}</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection 