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
            <a class="nav-link active" href="{{ URL::to('admin/feedback') }}">{{ __('Feedbacks') }}</a>
        </li>
      </ul>
</div>

<div class="container my-3">
  <div class="card text-dark border-dark">
    <div class="card-body d-flex justify-content-between">
      <h3>Manage Projects Data Table</h3>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center my-2">
      <table class="mx-5 table table-sm table-bordered table-hover">
        <tr class="bg-info">
            <th>#</th>
            <th>Created By</th>
            <th>At Project ID</th>
            <th>Comment</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
      @foreach ($feedbacks as $key => $feedback)
      <tr class="table-info">
          <td>{{ $feedback->id }}</td>
          <td>{{ $feedback->user->name }}</td>
          <td>{{ $feedback->project_id }}</td>
          <td>{{ $feedback->comment }}</td>
          <td>{{ $feedback->created_at }}</td>
          <td>{{ $feedback->updated_at }}</td>
          <td>
            <a type="button" class="btn btn-primary" href="#"><i class="fa fa-edit"></i>{{ __(' Edit') }}</a>
            <a type="button" class="btn btn-danger" href="#"><i class="fa fa-trash"></i>{{ __(' Delete') }}</a>
          </td>
      </tr>
      @endforeach
    </table>
</div>

{{-- Edit User --}}

{{-- Delete User --}}

@endsection