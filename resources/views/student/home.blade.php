@extends('layout.layStu')

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
                    <td>Due Date</td>
                    <td>Team</td>
                    <td>Advisor</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            @foreach($group_projects as $groupProject)
                <tr>
                    <td>{{ $groupProject->id }}</td>
                    <td>{{ $groupProject->project_title }}</td>
                    <td>{{ $groupProject->project_category }}</td>
                    <td>{{ $groupProject->year_term }}</td>
                    <td>{{ $groupProject->due_date }}</td>
                    <td>{{ $groupProject->team }}</td>
                    <td>{{ $groupProject->advisor }}</td>

                    <td>       
                        <a class="btn btn-small btn-success" href="{{ URL::to('project/' . $groupProject->id) }}">Show</a>        
                    </td>
                </tr>
            @endforeach
            </tbody>
        <table>
    </div>
</div>
@endsection