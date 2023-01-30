@extends('layout.layFac')

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
</div>
@endsection 