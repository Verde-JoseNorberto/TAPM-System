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
          <a class="nav-link" href="{{ URL::to('admin/task') }}">{{ __('Tasks') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ URL::to('admin/team') }}">{{ __('Teams') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ URL::to('admin/feedback') }}">{{ __('Feedbacks') }}</a>
        </li>
      </ul>
</div>

<div class="container my-3">
  <div class="card text-dark border-dark">
    <div class="card-body d-flex justify-content-between">
      <h3>Manage Teams Data Table</h3>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center my-2">
      <table class="mx-5 table table-sm table-bordered table-hover">
        <tr class="bg-info">
            <th>#</th>
            <th>User</th>
            <th>At Group</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
      @foreach ($members as $key => $member)
      <tr class="table-info">
          <td>{{ $member->id }}</td>
          <td>{{ $member->user->name }}</td>
          <td>{{ $member->group_project->title }}</td>
          <td>{{ $member->created_at }}</td>
          <td>{{ $member->updated_at }}</td>
          <td>
            <a type="button" class="btn btn-danger" href="#delete{{$member->id}}" data-bs-toggle="modal"><i class="fa fa-trash"></i>{{ __(' Delete') }}</a>
          </td>
      </tr>

      {{-- Delete Member --}}
      <div class="modal fade" id="delete{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Delete Task')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('admin/team') }}">
                @csrf 
                @method("DELETE")

                <h4>Are you sure you want to Delete: {{ $member->user->name }}?</h4>
                <input type="hidden" id="id" name="id" value="{{ $member->id }}">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
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