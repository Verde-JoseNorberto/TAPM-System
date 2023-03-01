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
            <th>Created By</th>
            <th>Title</th>
            <th>Subject</th>
            <th>Section</th>
            <th>Team</th>
            <th>Adviser</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
      @foreach ($group_projects as $key => $groupProject)
      <tr class="table-info">
          <td>{{ $groupProject->id }}</td>
          <td>{{ $groupProject->user->name }}</td>
          <td>{{ $groupProject->title }}</td>
          <td>{{ $groupProject->subject }}</td>
          <td>{{ $groupProject->section }}</td>
          <td>{{ $groupProject->team }}</td>
          <td>{{ $groupProject->advisor }}</td>
          <td>{{ $groupProject->created_at }}</td>
          <td>{{ $groupProject->updated_at }}</td>
          <td>
            <a type="button" class="btn btn-primary" href="#" data-bs-toggle="modal"><i class="fa fa-edit"></i>{{ __(' Edit') }}</a>
            <a type="button" class="btn btn-danger" href="#" data-bs-toggle="modal"><i class="fa fa-trash"></i>{{ __(' Delete') }}</a>
          </td>
      </tr>

      {{-- Edit User --}}
      <div class="modal fade" id="edit{{$groupProject->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Edit User')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('admin/group') }}">
                @csrf 
                @method("PUT")

                <input type="hidden" id="id" name="id" value="{{ $groupProject->id }}">
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Name') }}</label>
                      <input id="name" type="text" class="form-control" name="name" value="{{ $groupProject->name }}">
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Email') }}</label>
                      <input id="email" type="email" class="form-control" name="email" value="{{ $groupProject->email }}">
                    </div>
                  </div>
                </div>
      
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Password') }}</label>
                      <input id="password" type="password" class="form-control" name="password" >
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Type') }}</label>
                      <select id="type" class="form-select" name="type">
                          <option selected>{{ __('Select Type') }}</option>
                          <option value="0">{{ __('Office') }}</option>
                          <option value="1">{{ __('Teacher') }}</option>
                          <option value="2">{{ __('Adviser') }}</option>
                          <option value="3">{{ __('Student') }}</option>
                        </select>
                    </div>
                  </div>
      
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Update Details') }}</button>
                </div>
              </form>
          </div>
        </div>
      </div>

      {{-- Delete User --}}
      @endforeach
    </table>
</div>
@endsection