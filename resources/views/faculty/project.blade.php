@extends('layout.layFac')

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
    <div class="form-group">
      <br><h2>{{ $group_projects->title }}</h2>
      <strong>Team:</strong> {{ $group_projects->team }}<br>
      <strong>Advisor:</strong> {{ $group_projects->advisor }}
    </div>
  </div>
  <div class="col my-4">
    <div class="card h-100">
      <div class="card-body">
        <a class="btn btn-outline-dark text-decoration-none" href="{{ URL::to('faculty/project/' . $group_projects->id . '/task') }}">
          {{ __('Taskboard') }}</a>
      </div>
    </div>
  </div>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    @include('faculty.post', ['projects' => $group_projects->projects, 'group_project_id' => $group_projects->id])
  </div>
</div>
@endsection 