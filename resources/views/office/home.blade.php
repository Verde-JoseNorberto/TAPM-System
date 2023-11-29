@extends('layout.layOff')

@section('page-content')
<div class="container my-4">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($group_projects as $key => $groupProject)
            <div class="col flex">
                <div class="card h-100">
                    <a href="{{ URL::to('office/project/' . $groupProject->id) }}" class="btn h-100">
                        <div class="card-body" style="max-height: 150px; overflow: hidden;">
                            <h3 class="card-title text-truncate">{{ $groupProject->title }}</h3>
                            <h6 class="text-truncate">{{ $groupProject->section }}</h6>
                            <h6 class="text-truncate">{{ $groupProject->team }}</h6>
                            <h6 class="text-truncate">{{ $groupProject->advisor }}</h6>
                        </div>
                    </a>
                    <div class="dropdown position-absolute top-0 end-0 my-1 mx-2">
                        <i id="dropdownMenu" class="fa fa-ellipsis-v" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="dropdown-item" href="{{ URL::to('office/project/' . $groupProject->id) }}">
                                    {{ __('Show')}}
                                </a></li>
                                
                            @if($groupProject->members->where('user_id', auth()->user()->id)->first()->role == 'admin')
                                <li><a href="#edit{{$groupProject->id}}" class="dropdown-item" data-bs-toggle="modal">
                                    {{ __('Edit')}}
                                </a></li>
                                <li><a href="#delete{{$groupProject->id}}" class="dropdown-item" data-bs-toggle="modal">
                                    {{ __('Delete')}}
                                </a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @include('office.edit')
        @endforeach
    </div>
</div>
@endsection