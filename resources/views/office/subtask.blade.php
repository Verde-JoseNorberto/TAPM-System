<div class="row row-cols-1 row-cols-md-3 g-4 my-2"> 
    @foreach($tasks->subtasks as $subtask)
    <div class="col flex my-2">
      <div class="card border-primary text-primary">
        <a href="#modify{{ $subtask->id }}" class="btn" data-bs-toggle="modal">
            <div class="card-header">
            <h3 class="card-title">{{ $subtask->title }}</h3>
            </div>
            <div class="card-body">
            <p>{{ $subtask->content }}</p><hr>
            <div class="d-flex justify-content-between">
                <p>{{ __('Status: ' . $subtask->status) }}</p><p>{{ __('Start: ' . $subtask->start_date) }}</p>
            </div>
            <div class="d-flex justify-content-between">
                <p>{{ __('Priority: ' . $subtask->priority) }}</p><p>{{ __('Due: ' . $subtask->due_date) }}</p>
            </div>
            @if ($subtask->assign)
                <p>{{ __('Assigned to: ' . $subtask->assign->name) }}</p>
            @endif
            </div>
            <div class="card-footer">
            @if ($subtask->updatedBy)
                <strong>{{ $subtask->updatedBy->name }}{{ __(' updated the subtask.') }}</strong>
            @else
                <strong>{{ $subtask->user->name }}{{ __(' made the subtask.') }}</strong>
            @endif
            </div>
        </a>
      </div>
    </div>
    {{-- Edit Task --}}
    <div class="modal fade" id="modify{{$subtask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{__('Edit Subtask')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('office/update') }}">
              @csrf 
              @method("PUT")

              <input type="hidden" id="id" name="id" value="{{ $subtask->id }}">

              <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <label class="form-label">{{ __('Title') }}</label>
                    <input id="title" type="text" class="form-control" name="title" value="{{ $subtask->title }}">
                  </div>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <label class="form-label">{{ __('Content') }}</label>
                    <textarea id="content" class="form-control" rows="4" name="content">{{ $subtask->content }}</textarea>
                  </div>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <label class="form-label">{{ __('Start Date') }}</label>
                    <input id="start_date" type="date" class="form-control" name="start_date" value="{{ $subtask->start_date }}">
                  </div>
                </div>

                <div class="col">
                  <div class="form-outline">
                    <label class="form-label">{{ __('Due Date') }}</label>
                    <input id="due_date" type="date" class="form-control" name="due_date" value="{{ $subtask->due_date }}">
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
                          <option value="{{ $member->user->id }}" {{ $subtask->assign_id == $member->user->id ? 'selected' : '' }}>{{ $member->user->name }}</option>
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
                      <option selected>{{ $subtask->priority }}</option>
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
                      <option selected>{{ $subtask->status }}</option>
                      <option value="To Do">{{ __('To Do') }}</option>
                      <option value="In Progress">{{ __('In Progress') }}</option>
                      <option value="Finished">{{ __('Finished') }}</option>
                    </select>
                  </div>
                </div>
              </div>
              
              <input id="task_id" type="hidden" name="task_id" value="{{ $tasks->id }}">

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Update Subtask') }}</button>
                <a href="#remove{{$subtask->id}}" class="btn btn-danger" data-bs-toggle="modal">
                  {{ __('Delete') }}
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Delete Task --}}
    <div class="modal fade" id="remove{{$subtask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{__('Delete Task')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('office/subtask') }}">
              @csrf
              @method("DELETE")
              <h4>Are you sure you want to Delete Task: {{ $subtask->title }}?</h4>
              <input type="hidden" name="id" id="id" value="{{ $subtask->id }}">
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">{{ __('Delete Task') }}</button>
            <a href="#edit{{$subtask->id}}" class="btn btn-secondary" data-bs-toggle="modal">
              {{ __('Cancel') }}
            </a>
            </form>
          </div>
        </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>