@extends('layout.layStu')

@section('page-content')
  <div class="container my-2">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id) }}">{{ __('Project') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id . '/event') }}">{{ __('Events') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active">{{ __('Progress') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
      </li>
    </ul>

    <div class="card text-dark border-dark my-3">
        <div class="card-body">
          <h2>{{ $group_projects->title }}</h2>
          <strong>{{ __('Team:') }}</strong> {{ $group_projects->team }}<br>
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
      <div class="col-md-6">
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
                </tr>
              </thead>
              <tbody>
                @foreach($group_projects->tasks as $task)
                  <tr>
                    <td class="text-truncate" style="max-width: 150px;">{{ $task->title }}</td>
                    <td>{{ $task->status }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Subtask Status</h3>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>{{ __('Subtasks') }}</th>
                  <th>{{ __('Status') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($group_projects->tasks as $task)
                  @foreach($task->subtasks as $subtask)
                    <tr>
                      <td class="text-truncate" style="max-width: 150px;">{{ $subtask->title }}</td>
                      <td>{{ $subtask->status }}</td>
                    </tr>
                  @endforeach
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
