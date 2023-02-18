@extends('layout.layDir')

@section('page-content')
<div class="container my-4">
    <div class="col my-4">
        <div class="row">
            <div class="card h-100">
                <div class="card-body">
                  <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('office/project/' . $group_projects->id) }}">
                    {{ __('Project Page') }}</a>
                </div>

            </div>
        </div>
    </div>
    @foreach($tasks as $key => $task)
    <div class="col flex my-4">
      <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">{{ $tasks->title }}</h3>
          <h6>{{ $tasks->content }}</h6>
          <h6>{{ $tasks->due_date }}</h6>
        </div>
      </div>
    </div>
    @endforeach
</div>
@endsection 