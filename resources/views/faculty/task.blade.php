@extends('layout.layFac')

@section('page-content')
<div class="container my-4">
    <div class="col my-4">
        <div class="row">
            <div class="card h-100">
                <div class="card-body">
                  <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('faculty/project/' . $group_projects->id) }}">
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Add Task')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('faculty/task') }}">
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
                      <label class="form-label">{{ __('Content') }}</label>
                      <textarea id="content" class="form-control" rows="4" name="content"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Due Date') }}</label>
                      <input id="due_date" type="date" class="form-control" name="due_date">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Create Task') }}</button>
                </div>
              </form>
          </div>
        </div>
    </div>
</div>
@endsection 