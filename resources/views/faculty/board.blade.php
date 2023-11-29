<div class="row row-cols-1 row-cols-md-3 g-4 my-2"> 
  @foreach($tasks->sort(function($a, $b) {
    $order = ['High', 'Moderate', 'Low'];
    return array_search($a->priority, $order) <=> array_search($b->priority, $order);
  }) as $key => $task)
    <div class="col flex my-2">
      <div class="card border-primary text-primary">
        <a href="{{ URL::to('faculty/project/' . $group_projects->id . '/task-' . $task->id) }}" class="btn">
          <div class="card-header">
            <h3 class="card-title">{{ $task->title }}</h3>
          </div>
          <div class="card-body">
            <p>{{ $task->content }}</p><hr>
            <div class="d-flex justify-content-between">
              <p>{{ __('Status: ' . $task->status) }}</p><p>{{ __('Start: ' . $task->start_date) }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p>{{ __('Priority: ' . $task->priority) }}</p><p>{{ __('Due: ' . $task->due_date) }}</p>
            </div>
            @if ($task->assign)
              <p>{{ __('Assigned to: ' . $task->assign->name) }}</p>
            @endif
          </div>
          <div class="card-footer">
            @if ($task->updatedBy)
              <strong>{{ $task->updatedBy->name }}{{ __(' updated the task.') }}</strong>
            @else
              <strong>{{ $task->user->name }}{{ __(' made the task.') }}</strong>
            @endif
          </div>
        </a>
      </div>
    </div>
  @endforeach
</div>