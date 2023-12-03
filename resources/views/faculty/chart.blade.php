@extends('layout.layFac')

@section('page-content')
  <div class="container my-2">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id) }}">{{ __('Updates') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/event') }}">{{ __('Events') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active">{{ __('Progress') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
      </li>
    </ul>

    <div class="card text-dark border-dark my-3">
        <div class="card-body">
          <h2>{{ $group_projects->team }}</h2>
          <strong>{{ __('Project Title:') }}</strong> {{ $group_projects->title }}<br>
          <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
        </div>
    </div>

    <h2>{{ __('Progress Chart') }}</h2>

    <div class="row my-3">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Task Progress</h3>
          </div>
          <div class="card-body">
            <canvas id="taskProgressChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Subtask Progress</h3>
          </div>
          <div class="card-body">
            <canvas id="subtaskProgressChart"></canvas>
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
                  <th>{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($group_projects->tasks as $task)
                  <tr>
                    <td class="text-truncate" style="max-width: 200px;">{{ $task->title }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
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
                                      <th>{{ __('Tasks') }}</th>
                                      <th>{{ __('Status') }}</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <td class="text-truncate" style="max-width: 200px;">{{ $subtask->title }}</td>
                                        <td>{{ $subtask->status }}</td>
                                      </tr>
                                  </tbody>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button id="deleteEventBtn" type="button" class="btn btn-danger">{{ __('Delete Event') }}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Data for tasks
      var taskData = @json($taskData);

      // Data for subtasks
      var subtaskData = @json($subtaskData);

      // Chart for tasks
      var taskCanvas = document.getElementById('taskProgressChart').getContext('2d');
      var taskChart = new Chart(taskCanvas, {
        type: 'doughnut',
        data: {
          labels: ['To Do', 'In Progress', 'Finished'],
          datasets: [{
            data: taskData,
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
      var subtaskCanvas = document.getElementById('subtaskProgressChart').getContext('2d');
      var subtaskChart = new Chart(subtaskCanvas, {
        type: 'doughnut',
        data: {
          labels: ['To Do', 'In Progress', 'Finished'],
          datasets: [{
            data: subtaskData,
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
@endsection
