@extends('layout.layFac')

@section('page-content')
<div class="container my-4">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($group_projects as $groupProject)
        <div class="col flex">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title">{{ $groupProject->project_title }}</h3>
                    <h6>{{ $groupProject->project_category }}</h6>
                    <h6>{{ $groupProject->year_term }}</h6>
                    <h6>{{ $groupProject->team }}</h6>
                    <h6>{{ $groupProject->advisor }}</h6>
                    <a class="btn btn-small btn-success streched-link" href="{{ URL::to('project/' . $groupProject->id) }}">Show</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection