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
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/event') }}">{{ __('Events') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/progress') }}">{{ __('Progress') }}</a>
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
      @if($group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'admin' || $group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'project_manager')
      <button class="btn btn-dark position-absolute top-0 end-0 my-3 mx-3" data-bs-toggle="modal" data-bs-target="#taskModal">
        {{ __('Add Task') }}</button>
      @endif
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

  {{-- Status Tabs --}}
  <ul class="nav nav-tabs row-cols-1 row-cols-md-3 g-4 my-2" id="taskStatusTabs">
    <li class="nav-item">
      <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo">{{ __('To Do') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="inProgress-tab" data-bs-toggle="tab" href="#inProgress">{{ __('In Progress') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="finished-tab" data-bs-toggle="tab" href="#finished">{{ __('Finished') }}</a>
    </li>
  </ul>

  {{-- Status Tab Content --}}
  <div class="tab-content">
    <div class="tab-pane fade show active" id="todo">
      @include('office.board', ['tasks' => $group_projects->tasks->where('status', 'To Do'), 'group_project_id' => $group_projects->id])
    </div>
    <div class="tab-pane fade" id="inProgress">
      @include('office.board', ['tasks' => $group_projects->tasks->where('status', 'In Progress'), 'group_project_id' => $group_projects->id])
    </div>
    <div class="tab-pane fade" id="finished">
      @include('office.board', ['tasks' => $group_projects->tasks->where('status', 'Finished'), 'group_project_id' => $group_projects->id])
    </div>
  </div>

  {{-- Add Task --}}
  <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('Add Task')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('office/task') }}">
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
                  <label class="form-label">{{ __('Start Date') }}</label>
                  <input id="start_date" type="date" class="form-control" name="start_date">
                </div>
              </div>
 
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
                  <label class="form-label">{{ __('Assign to Member') }}</label>
                  <select id="assign_id" class="form-select" name="assign_id">
                      <option selected>{{ __('Select Member') }}</option>
                      @foreach($group_projects->members as $member)
                      <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Priority') }}</label>
                  <select id="priority" class="form-select" name="priority">
                    <option selected>{{ __('Select Status') }}</option>
                    <option value="Low">{{ __('Low') }}</option>
                    <option value="Moderate">{{ __('Moderate') }}</option>
                    <option value="High">{{ __('High') }}</option>
                  </select>
                </div>
              </div>

              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Status') }}</label>
                  <select id="status" class="form-select" name="status">
                    <option selected>{{ __('Select Status') }}</option>
                    <option value="To Do">{{ __('To Do') }}</option>
                    <option value="In Progress">{{ __('In Progress') }}</option>
                    <option value="Finished">{{ __('Finished') }}</option>
                  </select>
                </div>
              </div>
            </div>

            <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">
            <input type="hidden" name="sub_task" value="0">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">{{ __('Create Task') }}</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection 