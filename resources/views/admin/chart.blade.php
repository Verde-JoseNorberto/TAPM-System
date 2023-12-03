@extends('layout.layAdm')

@section('page-content')
<div class="container my-4">
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('admin/user') }}">{{ __('Users') }}</a>
    </li> 
    <li class="nav-item">
        <a class="nav-link " href="{{ URL::to('admin/group') }}">{{ __('Groups') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('admin/task') }}">{{ __('Tasks') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ URL::to('admin/chart') }}">{{ __('Progress') }}</a>
    </li>
    </ul>
</div>

<div class="container my-3">
  <div class="card text-dark border-dark">
    <div class="card-body d-flex justify-content-between">
      <h3>Manage Progress Data</h3>
    </div>
  </div>

  @foreach ($group_projects as $group_project)
  <div class="accordion my-1" id="accordion{{ $group_project->id }}">
    <div class="accordion-item">
      <h2 class="accordion-header bg-dark-subtle border border-dark-subtle" id="heading{{ $group_project->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $group_project->id }}" aria-expanded="true" aria-controls="collapse{{ $group_project->id }}">
          {{ __('Progress Chart of ') }} {{ $group_project->team }}
        </button>
      </h2>
      <div id="collapse{{ $group_project->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $group_project->id }}" data-bs-parent="#accordion{{ $group_project->id }}">
        <div class="accordion-body">
          
          <div class="row my-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Task Progress</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="taskProgressChart_{{ $group_project->id }}"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Subtask Progress</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="subtaskProgressChart_{{ $group_project->id }}"></canvas>
                    </div>
                </div>
            </div>
          </div>

          <div class="row my-3">
            <div class="col">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Task Status</h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>{{ __('Tasks') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Assign To') }}</th>
                        <th>{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($group_project->tasks as $task)
                        <tr>
                          <td class="text-truncate" style="max-width: 200px;">{{ $task->title }}</td>
                          <td>{{ $task->status }}</td>
                          <td>{{ $task->assign->name }}</td>
                          <td>
                            @if ($task->trashed())
                                <a type="button" class="btn btn-warning" href="#restoreTask{{$task->id}}" data-bs-toggle="modal">
                                    <i class="fa fa-undo"></i>{{ __(' Restore') }}
                                </a>
                            @else
                                <a href="#deleteTask{{$task->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                                    {{ __('Archive') }}
                                </a>
                            @endif
                            @foreach($task->subtasks as $subtask)
                              <a href="#view{{$subtask->id}}" type="button" class="btn btn-secondary" data-bs-toggle="modal">
                              {{ __('View Subtasks') }}</a>

                              <div class="modal fade" id="view{{$subtask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">List of Subtasks of Task: {{ $task->title }}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <table class="table">
                                        <thead>
                                          <tr>
                                            <th>{{ __('Subtasks') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Assign To') }}</th>
                                            <th>{{ __('Action') }}</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                              <td class="text-truncate" style="max-width: 200px;">{{ $subtask->title }}</td>
                                              <td>{{ $subtask->status }}</td>
                                              <td>{{ $subtask->assign->name }}</td>
                                              <td>
                                              @if ($subtask->trashed())
                                                  <a type="button" class="btn btn-warning" href="#restore{{$subtask->id}}" data-bs-toggle="modal">
                                                      <i class="fa fa-undo"></i>{{ __(' Restore') }}
                                                  </a>
                                              @else
                                                  <a href="#delete{{$subtask->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                                                      {{ __('Archive') }}
                                                  </a>
                                              @endif
                                              </td>
                                            </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              {{-- Archive Subtask --}}
                              <div class="modal fade" id="delete{{$subtask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">{{__('Archive Subtask')}}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form method="POST" action="{{ route('admin/chart') }}">
                                        @csrf 
                                        @method("DELETE")

                                        <h4>Are you sure you want to Archive: {{ $subtask->title }}?</h4>
                                        <input type="hidden" id="id" name="id" value="{{ $subtask->id }}">

                                        <div class="modal-footer">
                                          <button type="submit" class="btn btn-danger">{{ __('Archive') }}</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              {{-- Restore Subtask --}}
                              <div class="modal fade" id="restore{{$subtask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">{{__('Restore Subtask')}}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form method="POST" action="{{ route('admin.subtask.restore', ['id' => $subtask->id]) }}">
                                        @csrf 
                                        @method("POST")

                                        <h4>Are you sure you want to Restore: {{ $subtask->title }}?</h4>
                                        <input type="hidden" id="id" name="id" value="{{ $subtask->id }}">

                                        <div class="modal-footer">
                                          <button type="submit" class="btn btn-danger">{{ __('Restore') }}</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </td>
                        </tr>
                        {{-- Archive Task --}}
                        <div class="modal fade" id="deleteTask{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">{{__('Archive Task')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="{{ route('admin/task') }}">
                                  @csrf 
                                  @method("DELETE")

                                  <h4>Are you sure you want to Archive: {{ $task->title }}?</h4>
                                  <input type="hidden" id="id" name="id" value="{{ $task->id }}">

                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">{{ __('Archive') }}</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        {{-- Restore Task --}}
                        <div class="modal fade" id="restoreTask{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">{{__('Restore Task')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="{{ route('admin.task.restore', ['id' => $task->id]) }}">
                                  @csrf 
                                  @method("POST")

                                  <h4>Are you sure you want to Restore: {{ $task->title }}?</h4>
                                  <input type="hidden" id="id" name="id" value="{{ $task->id }}">

                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">{{ __('Restore') }}</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Data for tasks
      var taskData_{{ $group_project->id }} = @json($taskData[$group_project->id] ?? []);

      // Data for subtasks
      var subtaskData_{{ $group_project->id }} = @json($subtaskData[$group_project->id] ?? []);

      // Chart for tasks
      var taskCanvas_{{ $group_project->id }} = document.getElementById('taskProgressChart_{{ $group_project->id }}').getContext('2d');
      var taskChart_{{ $group_project->id }} = new Chart(taskCanvas_{{ $group_project->id }}, {
        type: 'doughnut',
        data: {
          labels: ['To Do', 'In Progress', 'Finished'],
          datasets: [{
            data: taskData_{{ $group_project->id }},
            backgroundColor: ['#36A2EB', '#FFCE56', '#00A36C'],
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Task Progress',
          },
        },
      });

      // Chart for subtasks
      var subtaskCanvas_{{ $group_project->id }} = document.getElementById('subtaskProgressChart_{{ $group_project->id }}').getContext('2d');
      var subtaskChart_{{ $group_project->id }} = new Chart(subtaskCanvas_{{ $group_project->id }}, {
        type: 'doughnut',
        data: {
          labels: ['To Do', 'In Progress', 'Finished'],
          datasets: [{
            data: subtaskData_{{ $group_project->id }},
            backgroundColor: ['#36A2EB', '#FFCE56', '#00A36C'],
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Subtask Progress',
          },
        },
      });
    });
  </script>
  @endforeach
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>
@endsection