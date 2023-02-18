@foreach($tasks as $key => $task)
<div class="col flex my-4">
  <div class="card">
    <div class="card-body">
      <strong>{{ $task->user->name }}{{ __(' made a task.') }}</strong>
      <h3 class="card-title">{{ $task->title }}</h3>
      <p>{{ $task->content }}<p>
      <p>{{ $task->due_date }}</p>
      <p>{{ $task->status}}</p>
    </div>
  </div>
</div>
@endforeach