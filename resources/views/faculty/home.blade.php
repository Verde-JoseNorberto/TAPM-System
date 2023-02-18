@extends('layout.layFac')

@section('page-content')
<div class="col-3">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>{{ $message }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
  </div>
<div class="container my-4">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($group_projects as $key => $groupProject)
        <div class="col flex">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title">{{ $groupProject->title }}</h3>
                    <h6>{{ $groupProject->subject }}</h6>
                    <h6>{{ $groupProject->section }}</h6>
                    <h6>{{ $groupProject->team }}</h6>
                    <h6>{{ $groupProject->advisor }}</h6>
                    <div class="dropdown">
                        <button id="dropdownMenu" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Actions') }}
                        </button>
                    
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="dropdown-item" href="{{ URL::to('faculty/project/' . $groupProject->id) }}">
                                {{ __('Show')}}
                            </a></li>
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal">
                                {{ __('Edit')}}
                            </button></li>
                            {{-- <li><a class="dropdown-item" href="{{ URL::to('faculty/project/' . $groupProject->id . '/edit') }}">
                                {{ __('Edit')}}
                            </a></li> --}}
                            {{-- <li>
                                <form method="DELETE" action="{{ route('faculty/home') }}" >
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('Delete')}}</button>
                                </form>
                            </li> --}}  
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('Edit Project')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('faculty/home', $groupProject->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" id='id' name="id">

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Project Title') }}</label>
                  <input id="title" type="text" class="form-control" name="title">
                </div>
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Subject') }}</label>
                  <input id="subject" type="text" class="form-control" name="subject">
                </div>
              </div>
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Section') }}</label>
                  <input id="section" type="text" class="form-control" name="section">
                </div>
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Team') }}</label>
                  <input id="team" type="text" class="form-control" name="team">
                </div>
              </div>
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Advisor') }}</label>
                  <input id="advisor" type="text" class="form-control" name="advisor">
                </div>
              </div>
            </div>
            
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">{{ __('Create Project') }}</button>
            </div>
          </form>
      </div>
    </div>
</div>
@endsection