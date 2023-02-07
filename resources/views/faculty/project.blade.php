@extends('layout.layFac')

@section('page-content')
<div class="container my-4">
  <div class="col my-4">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <br><h2>{{ $group_projects->project_title }}</h2>
                <strong>Team:</strong> {{ $group_projects->team }}<br>
                <strong>Advisor:</strong> {{ $group_projects->advisor }}
            </div>
        </div>
    </div>
  </div>
    <div class="row">
      <div class="card h-100">
          <div class="card-body">
            <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('facuulty/project/' . $group_projects->id) }}">
              {{ __('Taskboard') }}</a>
          </div>
      </div>
    </div>
  <div class="row row-cols-1 row-cols-md-2 g-4">
@if (is_array($projects) || is_object($projects))
  @foreach($projects as $key => $project)
    <div class="col flex my-4">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">{{ $projects->title }}</h3>
          <h6>{{ $projects->file }}</h6>
          <h6>{{ $projects->description }}</h6>
        </div>
      </div>
    </div>
  @endforeach
@endif
  </div>
</div>
@endsection 