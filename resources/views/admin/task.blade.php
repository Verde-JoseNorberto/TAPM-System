@extends('layout.layAdm')

@section('page-content')
<div class="container my-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/user') }}">{{ __('Users') }}</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="{{ URL::to('admin/group') }}">{{ __('Group Projects') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/project') }}">{{ __('Projects') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ URL::to('admin/task') }}">{{ __('Tasks') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/team') }}">{{ __('Teams') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ URL::to('admin/feedback') }}">{{ __('Feedbacks') }}</a>
        </li>
      </ul>
</div>

<div class="container my-3">
  <div class="card text-dark border-dark">
    <div class="card-body d-flex justify-content-between">
      <h3>Manage Tasks Data Table</h3>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center my-2">
      <table class="mx-5 table table-sm table-bordered table-hover">
        <tr class="bg-info">
            <th>#</th>
            <th>Created By</th>
            <th>At Group</th>
            <th>Title</th>
            <th>Content</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
      @foreach ($tasks as $key => $task)
      <tr class="table-info">
          <td>{{ $task->id }}</td>
          <td>{{ $task->user->name }}</td>
          <td>{{ $task->group_project->title }}</td>
          <td>{{ $task->title }}</td>
          <td>{{ $task->content }}</td>
          <td>{{ $task->due_date }}</td>
          <td>{{ $task->status }}</td>
          <td>{{ $task->assign->name }}</td>
          <td>{{ $task->created_at }}</td>
          <td>{{ $task->updated_at }}</td>
          <td>
            @if ($task->trashed())
                <a type="button" class="btn btn-warning" href="#restore{{$task->id}}" data-bs-toggle="modal">
                    <i class="fa fa-undo"></i>{{ __(' Restore') }}
                </a>
            @else
                <a href="#delete{{$task->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                    {{ __('Delete') }}
                </a>
            @endif
          </td>
      </tr>

      {{-- Delete Task --}}
      <div class="modal fade" id="delete{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Delete Task')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('admin/task') }}">
                @csrf 
                @method("DELETE")

                <h4>Are you sure you want to Delete: {{ $task->title }}?</h4>
                <input type="hidden" id="id" name="id" value="{{ $task->id }}">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      {{-- Restore Task --}}
      <div class="modal fade" id="restore{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </table>
</div>
@endsection