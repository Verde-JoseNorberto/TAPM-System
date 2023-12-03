@extends('layout.layAdm')

@section('page-content')
<div class="container my-4">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{ URL::to('admin/user') }}">{{ __('Users') }}</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link active" href="{{ URL::to('admin/group') }}">{{ __('Groups') }}</a>
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
            <h3>Manage Group Data</h3>
        </div>
    </div>

  @foreach ($group_projects as $key => $group_project)
  <div class="accordion my-1" id="accordion{{ $group_project->id }}">
      <div class="accordion-item">
          <h2 class="accordion-header bg-dark-subtle border border-dark-subtle" id="heading{{ $group_project->id }}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $group_project->id }}" aria-expanded="true" aria-controls="collapse{{ $group_project->id }}">
                  {{ __('Group Project: ') }} {{ $group_project->team }}
              </button>
          </h2>
          <div id="collapse{{ $group_project->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $group_project->id }}" data-bs-parent="#accordion{{ $group_project->id }}">
              <div class="accordion-body">
                  <div class="row my-3">
                      <div class="col-md-12">
                          <div class="card">
                              <div class="card-header d-flex justify-content-between">
                                  <h3 class="card-title">Group Members</h3>

                                  @if ($group_project->trashed())
                                      <a type="button" class="btn btn-warning" href="#restore{{$group_project->id}}" data-bs-toggle="modal">
                                          <i class="fa fa-undo"></i>{{ __(' Restore') }}
                                      </a>
                                  @else
                                      <a href="#delete{{$group_project->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                                          {{ __('Archive') }}
                                      </a>
                                  @endif
                  
                                  {{-- Delete Group --}}
                                  <div class="modal fade" id="delete{{$group_project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title">{{__('Archive Group')}}</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form method="POST" action="{{ route('admin/group') }}">
                                            @csrf 
                                            @method("DELETE")

                                            <h4>Are you sure you want to Archive: {{ $group_project->title }}?</h4>
                                            <input type="hidden" id="id" name="id" value="{{ $group_project->id }}">

                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-danger">{{ __('Archive') }}</button>
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
                              </div>
                              <div class="card-body">
                                  <table class="table">
                                      <tr class="bg-info">
                                          <th>#</th>
                                          <th>User</th>
                                          <th>Created At</th>
                                          <th>Updated At</th>
                                          <th>Action</th>
                                      </tr>
                                      @foreach ($group_project->members as $member)
                                      <tr class="table">
                                          <td>{{ $member->id }}</td>
                                          <td>{{ $member->user->name }}</td>
                                          <td>{{ $member->created_at }}</td>
                                          <td>{{ $member->updated_at }}</td>
                                          <td>
                                              @if ($member->trashed())
                                                  <a type="button" class="btn btn-warning" href="#restoreMember{{$member->id}}" data-bs-toggle="modal">
                                                      <i class="fa fa-undo"></i>{{ __(' Restore') }}
                                                  </a>
                                              @else
                                                  <a href="#deleteMember{{$member->id}}" type="button" class="btn btn-danger" data-bs-toggle="modal">
                                                      {{ __('Archive') }}
                                                  </a>
                                              @endif
                                          </td>
                                      </tr>

                                      {{-- Delete Member --}}
                                      <div class="modal fade" id="deleteMember{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title">{{__('Archive Member')}}</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form method="POST" action="{{ route('admin/team') }}">
                                                          @csrf 
                                                          @method("DELETE")

                                                          <h4>Are you sure you want to Archive: {{ $member->user->name }}?</h4>
                                                          <input type="hidden" id="id" name="id" value="{{ $member->id }}">

                                                          <div class="modal-footer">
                                                              <button type="submit" class="btn btn-danger">{{ __('Archive') }}</button>
                                                          </div>
                                                      </form>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      {{-- Restore Member --}}
                                      <div class="modal fade" id="restoreMember{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title">{{__('Restore Member')}}</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form method="POST" action="{{ route('admin.team.restore', ['id' => $member->id]) }}">
                                                          @csrf 
                                                          @method("POST")

                                                          <h4>Are you sure you want to Restore: {{ $member->user->name }}?</h4>
                                                          <input type="hidden" id="id" name="id" value="{{ $member->id }}">

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
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endforeach
</div>
@endsection