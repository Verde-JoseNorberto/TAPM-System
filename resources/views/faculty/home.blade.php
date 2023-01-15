@extends('layout.layFac')

@section('page-content')
<div class="container">
    <div class="row-md-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Title</td>
                    <td>Category</td>
                    <td>Year and Term</td>
                    <td>Team</td>
                    <td>Advisor</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            @foreach($group_projects as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->project_title }}</td>
                    <td>{{ $value->project_category }}</td>
                    <td>{{ $value->year_term }}</td>
                    <td>{{ $value->team }}</td>
                    <td>{{ $value->advisor }}</td>
                    
                    <td>       
                        <a class="btn btn-small btn-success" href="{{ URL::to('project/' . $value->id) }}">Show</a>        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection