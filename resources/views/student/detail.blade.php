@extends('layout.layStu')

@section('page-content')
  <div class="container my-2">

    <a class="btn btn-outline-dark my-2" href="{{ URL::to('project/' . $group_projects->id . '/task') }}">
      {{ __('Go Back to Taskboard') }}
    </a>

    <div class="card text-dark border-dark my-3">
      <div class="card-body">
        <h2>{{ $group_projects->title }}</h2>
        <strong>{{ __('Team:') }}</strong> {{ $group_projects->team }}<br>
        <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
        
        @if($group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'admin' || $group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'project_manager')
        <button class="btn btn-dark position-absolute top-0 end-0 my-3 mx-3" data-bs-toggle="modal" data-bs-target="#taskModal">
          {{ __('Add Subtask') }}</button>
        @endif
      </div>
    </div>

    <div class="card text-dark border-dark my-3">
      <div class="card-body">
        <div class="progress">
          <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
          aria-valuenow="{{ $subtasks }}" style="width: {{ $subtasks }}%" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 my-2"> 
      <div class="col flex my-2">
        <div class="card border-primary text-primary">
            <a href="#edit{{ $tasks->id }}" class="btn" data-bs-toggle="modal">
                <div class="card-header">
                <h3 class="card-title">{{ $tasks->title }}</h3>
                </div>
                <div class="card-body">
                <p>{{ $tasks->content }}</p><hr>
                <div class="d-flex justify-content-between">
                    <p>{{ __('Status: ' . $tasks->status) }}</p><p>{{ __('Start: ' . $tasks->start_date) }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>{{ __('Priority: ' . $tasks->priority) }}</p><p>{{ __('Due: ' . $tasks->due_date) }}</p>
                </div>
                @if ($tasks->assign)
                    <p>{{ __('Assigned to: ' . $tasks->assign->name) }}</p>
                @endif
                </div>
                <div class="card-footer">
                @if ($tasks->updatedBy)
                    <strong>{{ $tasks->updatedBy->name }}{{ __(' updated the task.') }}</strong>
                @else
                    <strong>{{ $tasks->user->name }}{{ __(' made the task.') }}</strong>
                @endif
                </div>
            </a>
        </div>
      </div>
      {{-- Edit Task --}}
<div class="modal fade" id="edit{{$tasks->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">{{__('Edit Task')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('student/detail') }}">
              @csrf 
              @method("PUT")

              <input type="hidden" id="id" name="id" value="{{ $tasks->id }}">

              <div class="row mb-4">
                  <div class="col">
                  <div class="form-outline">
                      <label class="form-label">{{ __('Title') }}</label>
                      <input id="title" type="text" class="form-control" name="title" value="{{ $tasks->title }}">
                  </div>
                  </div>
              </div>

              <div class="row mb-4">
                  <div class="col">
                  <div class="form-outline">
                      <label class="form-label">{{ __('Content') }}</label>
                      <textarea id="content" class="form-control" rows="4" name="content">{{ $tasks->content }}</textarea>
                  </div>
                  </div>
              </div>

              <div class="row mb-4">
                  <div class="col">
                  <div class="form-outline">
                      <label class="form-label">{{ __('Start Date') }}</label>
                      <input id="start_date" type="date" class="form-control" name="start_date" value="{{ $tasks->start_date }}">
                  </div>
                  </div>

                  <div class="col">
                  <div class="form-outline">
                      <label class="form-label">{{ __('Due Date') }}</label>
                      <input id="due_date" type="date" class="form-control" name="due_date" value="{{ $tasks->due_date }}">
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
                          <option value="{{ $member->user->id }}" {{ $tasks->assign_id == $member->user->id ? 'selected' : '' }}>{{ $member->user->name }}</option>
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
                      <option selected>{{ $tasks->priority }}</option>
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
                      <option selected>{{ $tasks->status }}</option>
                      <option value="To Do">{{ __('To Do') }}</option>
                      <option value="In Progress">{{ __('In Progress') }}</option>
                      <option value="Finished">{{ __('Finished') }}</option>
                      </select>
                  </div>
                  </div>
              </div>
              
              <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Update Task') }}</button>
                  <a href="#delete{{$tasks->id}}" class="btn btn-danger" data-bs-toggle="modal">
                  {{ __('Delete') }}
                  </a>
              </div>
              </form>
          </div>
      </div>
  </div>
</div>

{{-- Delete Task --}}
<div class="modal fade" id="delete{{$tasks->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{__('Delete Task')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('student/detail') }}">
        @csrf
        @method("DELETE")
        <h4>Are you sure you want to Delete Task: {{ $tasks->title }}?</h4>
        <input type="hidden" name="id" id="id" value="{{ $tasks->id }}">
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">{{ __('Delete Task') }}</button>
        <a href="#edit{{$tasks->id}}" class="btn btn-secondary" data-bs-toggle="modal">
        {{ __('Cancel') }}
        </a>
        </form>
      </div>
      </div>
  </div>
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
        @include('student.subtask', ['subtasks' => $tasks->subtasks->where('status', 'To Do'), 'task_id' => $tasks->id])
      </div>
      <div class="tab-pane fade" id="inProgress">
        @include('student.subtask', ['subtasks' => $tasks->subtasks->where('status', 'In Progress'), 'task_id' => $tasks->id])
      </div>
      <div class="tab-pane fade" id="finished">
        @include('student.subtask', ['subtasks' => $tasks->subtasks->where('status', 'Finished'), 'task_id' => $tasks->id])
      </div>
    </div>

{{-- Add Subtask --}}
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{__('Add Subtask')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('student/subtask') }}">
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
          <input id="task_id" type="hidden" name="task_id" value="{{ $tasks->id }}">
          
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('Create Subtask') }}</button>
          </div>
        </form>
    </div>
  </div>
</div>
@endsection