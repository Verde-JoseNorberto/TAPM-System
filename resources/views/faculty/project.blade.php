@extends('layout.layFac')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-outline-secondary" href="{{ route('director/home') }}">Back</a>
            </div>
        </div>
    </div>

    <div class="jumbotron text-center">
        <h2>{{ $group_projects->project_title }}</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Team:</strong> 
                    {{ $group_projects->team }}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Advisor:</strong> 
                    {{ $group_projects->advisor }}
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection 