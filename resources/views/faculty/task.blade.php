@extends('layout.layFac')

@section('page-content')
<div class="container my-4">
  <div class="col my-4">
    <div class="form-group">
      <br><h2>{{ $group_projects->title }}</h2>
      <strong>Team:</strong> {{ $group_projects->team }}<br>
      <strong>Advisor:</strong> {{ $group_projects->advisor }}
    </div>
  </div>
  <div class="col my-4">
    <div class="card h-100">
      <div class="card-body">
        <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('faculty/project/' . $group_projects->id) }}">
          {{ __('Project Page') }}</a>
      </div>
    </div>
  </div>
  <div class="row row-cols-1 row-cols-md-3 g-4">
  @include('faculty.board', ['tasks' => $group_projects->tasks, 'group_project_id' => $group_projects->id])
  </div>
</div>
@endsection 