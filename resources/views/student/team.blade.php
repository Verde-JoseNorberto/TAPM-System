@extends('layout.layStu')

@section('page-content')
<div class="container my-2">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id) }}">{{ __('Updates') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id . '/event') }}">{{ __('Events') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('project/' . $group_projects->id . '/progress') }}">{{ __('Progress') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active">{{ __('Team') }}</a>
      </li>
    </ul>
    <div class="card text-dark border-dark my-3">
        <div class="card-body">
          <h2>{{ $group_projects->team }}</h2>
          <strong>{{ __('Project Title:') }}</strong> {{ $group_projects->title }}<br>
          <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
        </div>
    </div>
    
    <div class="card text-dark border-dark my-3">
      <div class="card-header">
        <h3 class="card-title">{{ __('List of Members') }}</h3>
      </div>
      <div class="card-body">
        <h4 class="mb-4">{{ __('Admins') }}</h4>
        @foreach ($members->where('role', 'admin') as $key => $member)
          {{ $member->user->name }}
          @if($members->where('user_id', auth()->user()->id)->first()->role == 'admin')
          <i id="dropdownMenu" class="fa fa-ellipsis-v position-absolute end-0 mx-4" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                <li><a href="#edit{{$member->id}}" class="dropdown-item" data-bs-toggle="modal">
                        {{ __('Edit')}}
                    </a></li>
                <li><a href="#delete{{$member->id}}" class="dropdown-item" data-bs-toggle="modal">
                        {{ __('Remove')}}
                    </a></li>
            </ul>
          @endif
          <hr>
          
          {{-- Edit Members --}}
          <div class="modal fade" id="edit{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Update Permission')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('student/editTeam') }}">
                    @csrf
                    @method("PUT")
                    
                    <div class="row mb-4">
                      <div class="col">
                        <label class="form-label">{{ __('Modify Role') }}</label>
                        <select class="form-select" id="role" name="role">
                          <option value="admin">{{ __('Admin') }}</option>
                          <option value="project_manager">{{ __('Project Manager') }}</option>
                          <option value="member">{{ __('Member') }}</option>
                        </select>
                      </div>
                    </div>

                    <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                    <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Update') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          {{-- Remove Members --}}
          <div class="modal fade" id="delete{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Remove Members')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('student/team') }}">
                    @csrf
                    @method("DELETE")
                    <h4>Are you sure you want to remove: {{ $member->user->name }}?</h4>
                    <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach

        <h4 class="mt-4 mb-4">{{ __('Project Managers') }}</h4>
        @foreach ($members->where('role', 'project_manager') as $key => $member)
          {{ $member->user->name }}
          @if($members->where('user_id', auth()->user()->id)->first()->role == 'admin')
          <i id="dropdownMenu" class="fa fa-ellipsis-v position-absolute end-0 mx-4" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                <li><a href="#edit{{$member->id}}" class="dropdown-item" data-bs-toggle="modal">
                        {{ __('Edit')}}
                    </a></li>
                <li><a href="#delete{{$member->id}}" class="dropdown-item" data-bs-toggle="modal">
                        {{ __('Remove')}}
                    </a></li>
            </ul>
          @endif
          <hr>
          
          {{-- Edit Members --}}
          <div class="modal fade" id="edit{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Update Permission')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('student/editTeam') }}">
                    @csrf
                    @method("PUT")
                    
                    <div class="row mb-4">
                      <div class="col">
                        <label class="form-label">{{ __('Modify Role') }}</label>
                        <select class="form-select" id="role" name="role">
                          <option value="admin">{{ __('Admin') }}</option>
                          <option value="project_manager">{{ __('Project Manager') }}</option>
                          <option value="member">{{ __('Member') }}</option>
                        </select>
                      </div>
                    </div>

                    <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                    <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Update') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          {{-- Remove Members --}}
          <div class="modal fade" id="delete{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Remove Members')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('student/team') }}">
                    @csrf
                    @method("DELETE")
                    <h4>Are you sure you want to remove: {{ $member->user->name }}?</h4>
                    <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach

        <h4 class="mt-4 mb-4">{{ __('Members') }}</h4>
        @foreach ($members->where('role', 'member') as $key => $member)
          {{ $member->user->name }}
          @if($members->where('user_id', auth()->user()->id)->first()->role == 'admin')
          <i id="dropdownMenu" class="fa fa-ellipsis-v position-absolute end-0 mx-4" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                <li><a href="#edit{{$member->id}}" class="dropdown-item" data-bs-toggle="modal">
                        {{ __('Edit')}}
                    </a></li>
                <li><a href="#delete{{$member->id}}" class="dropdown-item" data-bs-toggle="modal">
                        {{ __('Remove')}}
                    </a></li>
            </ul>
          @endif
          <hr>
          
          {{-- Edit Members --}}
          <div class="modal fade" id="edit{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Update Permission')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('student/editTeam') }}">
                    @csrf
                    @method("PUT")
                    
                    <div class="row mb-4">
                      <div class="col">
                        <label class="form-label">{{ __('Modify Role') }}</label>
                        <select class="form-select" id="role" name="role">
                          <option value="admin">{{ __('Admin') }}</option>
                          <option value="project_manager">{{ __('Project Manager') }}</option>
                          <option value="member">{{ __('Member') }}</option>
                        </select>
                      </div>
                    </div>

                    <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                    <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Update') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          {{-- Remove Members --}}
          <div class="modal fade" id="delete{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Remove Members')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('student/team') }}">
                    @csrf
                    @method("DELETE")
                    <h4>Are you sure you want to remove: {{ $member->user->name }}?</h4>
                    <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      @if($members->where('user_id', auth()->user()->id)->first()->role == 'admin')
      <button class="btn btn-dark position-absolute top-0 end-0 my-2 mx-3" data-bs-toggle="modal" data-bs-target="#addModal">
        {{ __('Add Members') }}</button>
      @endif
    </div>
</div>

{{-- Add Members --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">{{__('Add Members')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{ route('student/team') }}" method="POST">
                  @csrf
                <div class="row mb-4">
                  <div class="col"> 
                    <label class="form-label">{{ __('Add Member') }}</label>
                    <select class="form-select" id="user_id" name="user_id">
                      <option selected>{{ __('Select Member') }}</option>
                      @foreach ($users as $user)
                          @if (!$group_projects->members->contains('user_id', $user->id))
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                          @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label">{{ __('Choose Role') }}</label>
                    <select class="form-select" id="role" name="role">
                      <option value="admin">{{ __('Admin') }}</option>
                      <option value="project_manager">{{ __('Project Manager') }}</option>
                      <option value="member">{{ __('Member') }}</option>
                    </select>
                  </div>
                </div>

                  <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">{{ __('Add Member') }}</button>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection