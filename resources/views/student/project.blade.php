@extends('layout.layStu')

@section('page-content')
<div >
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-dismissible fade show position-fixed" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show position-fixed" role="alert">
      @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
      @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
</div>
<div class="container my-4">
    <div class="col my-4">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <br><h2>{{ $group_projects->title }}</h2>
            <strong>Team:</strong> {{ $group_projects->team }}<br>
            <strong>Advisor:</strong> {{ $group_projects->advisor }}
        </div>
      </div>
    </div>
    <div class="col my-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="col-sm">
          <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('project/' . $group_projects->id . '/task') }}">
            {{ __('Taskboard') }}</a>
          <a class="btn btn-outline-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#updateModal">
            {{ __('Add Updates') }}</a>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 g-4">
      @include('student.post', ['projects' => $group_projects->projects, 'group_project_id' => $group_projects->id])
    </div>
    
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Add Project')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('student/project') }}" enctype="multipart/form-data">
                @csrf 
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Title') }}</label>
                      <input id="title" type="text" class="form-control" name="title">
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('File') }}</label>
                      <input id="file" type="file" class="form-control" name="file">
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Description') }}</label>
                      <textarea id="description" class="form-control" rows="4" name="description"></textarea>
                    </div>
                  </div>
                </div>

                <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Create Project') }}</button>
                </div>
              </form>
          </div>
        </div>
    </div>
</div>
@endsection 