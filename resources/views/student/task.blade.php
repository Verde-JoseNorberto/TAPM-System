@extends('layout.layStu')

@section('page-content')
<div class="container my-4">
    <div class="col my-4">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <br><h2>{{ $group_projects->title }}</h2>
            <strong>Team:</strong> {{ $group_projects->team }}<br>
            <strong>Advisor:</strong> {{ $group_projects->advisor }}
        </div>
      </div>
    </div>
    <div class="col my-4">
      <div class="card h-100">
          <div class="card-body">
            <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('project/' . $group_projects->id) }}">
              {{ __('Project Page') }}</a>
            <a class="btn btn-outline-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
              {{ __('Add Task') }}</a>
          </div>

      </div>
    </div>
    <div class="row">
      @include('student.board', ['tasks' => $group_projects->tasks, 'group_project_id' => $group_projects->id])
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Add Task')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('student/task') }}">
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

                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <select id="status" type="date" class="form-select" name="status">
                        <option selected>{{ __('Select Status') }}</option>
                        <option value="To Do">{{ __('To Do') }}</option>
                        <option value="In Progress">{{ __('In Progress') }}</option>
                        <option value="Finished ">{{ __('Finished') }}</option>
                      </select>
                    </div>
                  </div>
                </div>

                <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Create Task') }}</button>
                </div>
              </form>
          </div>
        </div>
    </div>
</div>
@endsection 