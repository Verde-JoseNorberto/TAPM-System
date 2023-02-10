@extends('layout.layFac')

@section('page-content')
<div class="col-3">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
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
                    <h3 class="card-title">{{ $groupProject->project_title }}</h3>
                    <h6>{{ $groupProject->project_category }}</h6>
                    <h6>{{ $groupProject->subject }}</h6>
                    <h6>{{ $groupProject->year_term }}</h6>
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
                            <li><a class="dropdown-item" href="{{ URL::to('faculty/project/' . $groupProject->id . '/edit') }}">
                                {{ __('Edit')}}
                            </a></li>
                            <li>
                                <form method="DELETE" action="{{ URL::to('faculty/project/' . $groupProject->id) }}" >
                                    @csrf
                                    <button type="submit" class="dropdown-item">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection