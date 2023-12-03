@extends('layout.layAdm')

@section('page-content')
<div class="container my-4">
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link active" href="{{ URL::to('admin/user') }}">{{ __('Users') }}</a>
      </li> 
      <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/group') }}">{{ __('Groups') }}</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/task') }}">{{ __('Tasks') }}</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('admin/chart') }}">{{ __('Progress') }}</a>
      </li>
    </ul>
</div>

<div class="container my-3">
  <div class="card text-dark border-dark">
    <div class="card-body d-flex justify-content-between">
      <h3>Manage Users Data</h3>
      <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addUser">
        {{__('Add User')}}
      </button>
    </div>
  </div>

  <div class="d-flex justify-content-center my-2">
        <table class="mx-5 table table-sm table-bordered table-hover">
          <tr class="bg-info">
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
          </tr>
        @foreach ($users as $key => $user)
        <tr class="table-info">
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->type }}</td>
            <td>
              @if ($user->trashed())
                  <!-- Restore button for soft-deleted user -->
                  <a type="button" class="btn btn-warning" href="#restore{{$user->id}}" data-bs-toggle="modal">
                      <i class="fa fa-undo"></i>{{ __(' Restore') }}
                  </a>
              @else
                  <!-- Edit and Delete buttons for active user -->
                  <a type="button" class="btn btn-primary" href="#edit{{$user->id}}" data-bs-toggle="modal">
                      <i class="fa fa-edit"></i>{{ __(' Edit') }}
                  </a>
                  <a href="#delete{{$user->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                      {{ __('Delete') }}
                  </a>
              @endif
            </td>
        </tr>
        
        {{-- Delete User --}}
        <div class="modal fade" id="delete{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{__('Delete User')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('admin/user') }}">
                  @csrf 
                  @method("DELETE")

                  <h4>Are you sure you want to Delete User: {{ $user->name }}?</h4>
                  <input type="hidden" id="id" name="id" value="{{ $user->id }}">

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ __('Delete User') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        {{-- Restore User --}}
        <div class="modal fade" id="restore{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{__('Restore User')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('admin.user.restore', ['id' => $user->id]) }}">
                  @csrf 
                  @method("POST")

                  <h4>Are you sure you want to Restore User: {{ $user->name }}?</h4>
                  <input type="hidden" id="id" name="id" value="{{ $user->id }}">

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ __('Restore User') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>


        {{-- Edit User --}}
        <div class="modal fade" id="edit{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{__('Edit User')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('admin/user') }}">
                  @csrf 
                  @method("PUT")

                  <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                  <div class="row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">
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
                            <option value="1">{{ __('Faculty') }}</option>
                            <option value="2">{{ __('Student') }}</option>
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
        @endforeach
      </table>
  </div>

  {{-- Add User --}}
  <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('Add New User')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('admin/user') }}">
            @csrf 
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Name') }}</label>
                  <input id="name" type="text" class="form-control" name="name">
                </div>
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Email') }}</label>
                  <input id="email" type="email" class="form-control" name="email">
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Password') }}</label>
                  <input id="password" type="password" class="form-control" name="password">
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
                      <option value="1">{{ __('Faculty') }}</option>
                      <option value="2">{{ __('Student') }}</option>
                    </select>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">{{ __('Add User') }}</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection