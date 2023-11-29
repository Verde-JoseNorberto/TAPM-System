@extends('layout.layAdm')

@section('page-content')
<div class="container my-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/user') }}">{{ __('Users') }}</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link active" href="{{ URL::to('admin/group') }}">{{ __('Group Projects') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ URL::to('admin/project') }}">{{ __('Projects') }}</a>
          </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/task') }}">{{ __('Tasks') }}</a>
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
      <h3>Manage Group Projects Data Table</h3>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center my-2">
      <table class="mx-5 table table-sm table-bordered table-hover">
        <tr class="bg-info">
            <th>#</th>
            <th>By User</th>
            <th>Title</th>
            <th>Subject</th>
            <th>Section</th>
            <th>Team</th>
            <th>Adviser</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
      @foreach ($group_projects as $key => $group_project)
      <tr class="table-info">
          <td>{{ $group_project->id }}</td>
          <td>{{ $group_project->user->name }}</td>
          <td>{{ $group_project->title }}</td>
          <td>{{ $group_project->subject }}</td>
          <td>{{ $group_project->section }}</td>
          <td>{{ $group_project->team }}</td>
          <td>{{ $group_project->advisor }}</td>
          <td>{{ $group_project->created_at }}</td>
          <td>{{ $group_project->updated_at }}</td>
          <td>
            @if ($group_project->trashed())
                <a type="button" class="btn btn-warning" href="#restore{{$group_project->id}}" data-bs-toggle="modal">
                    <i class="fa fa-undo"></i>{{ __(' Restore') }}
                </a>
            @else
                <a href="#delete{{$group_project->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                    {{ __('Delete') }}
                </a>
            @endif
          </td>
      </tr>

      {{-- Delete Group --}}
      <div class="modal fade" id="delete{{$group_project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Delete Group')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('admin/group') }}">
                @csrf 
                @method("DELETE")

                <h4>Are you sure you want to Delete: {{ $group_project->title }}?</h4>
                <input type="hidden" id="id" name="id" value="{{ $group_project->id }}">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      {{-- Restore Group --}}
      <div class="modal fade" id="restore{{$group_project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Restore Group')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('admin.group.restore', ['id' => $group_project->id]) }}">
                @csrf 
                @method("POST")

                <h4>Are you sure you want to Restore: {{ $group_project->title }}?</h4>
                <input type="hidden" id="id" name="id" value="{{ $group_project->id }}">

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