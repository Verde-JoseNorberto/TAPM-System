@extends('layout.layStu')

@section('page-content')
<div class="container my-4x">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <br><h2>{{ $group_projects->project_title }}</h2>
                <strong>Team:</strong> {{ $group_projects->team }}<br>
                <strong>Advisor:</strong> {{ $group_projects->advisor }}
            </div>
        </div>
    </div>
    @foreach ($projects as $project)
    <div class="col flex">
      <div class="card h-100">
        <div class="card-body">
          <h3 class="card-title">{{ $project->title }}</h3>
          <h6>{{ $project->file }}</h6>
          <h6>{{ $project->description }}</h6>
        </div>
      </div>
    </div>
    @endforeach
    <div class="container my-4">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col flex">
                <div class="card h-100">
                    <a class="card-block stretched-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <div class="card-body">
                        
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Add Project')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('student/project') }}">
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
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Create Project') }}</button>
                </div>
              </form>
          </div>
        </div>
    </div>
</div>
@endsection 