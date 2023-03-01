@extends('layout.layOff')

@section('page-content')
<div class="container my-2">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id) }}">{{ __('Project') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active">{{ __('Taskboard') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
    </li>
  </ul>
  <div class="card text-dark border-dark my-3">
    <div class="card-body">
      <h2>{{ $group_projects->title }}</h2>
      <strong>{{ __('Team:') }}</strong> {{ $group_projects->team }}<br>
      <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
      <button class="btn btn-dark position-absolute top-0 end-0 my-3 mx-3" data-bs-toggle="modal" data-bs-target="#taskModal">
        {{ __('Add Task') }}</button>
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
  
  <div class="row row-cols-1 row-cols-md-3 g-4 my-2">
    @include('office.board', ['tasks' => $group_projects->tasks, 'group_project_id' => $group_projects->id])
  </div>
</div>
@endsection 