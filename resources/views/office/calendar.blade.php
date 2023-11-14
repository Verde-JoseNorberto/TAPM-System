@extends('layout.layOff')

@section('page-content')
<div class="container my-2">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id) }}">{{ __('Project') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active">{{ __('Events') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
    </li>
  </ul>
  <div class="card text-dark border-dark my-3">
      <div class="card-body">
        <h2>{{ $group_projects->title }}</h2>
        <strong>{{ __('Team:') }}</strong> {{ $group_projects->team }}<br>
        <strong>{{ __('Subject:') }}</strong> {{ $group_projects->subject }}<br>
        <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
      </div>
  </div>

  <div id='calendar'></div>
</div>

<script>
  $(document).ready(function () {

  $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      }
  });

  var calendar = $('#calendar').fullCalendar({
      editable:true,
      header:{
          left:'prev,next today',
          center:'title',
          right:'month,agendaWeek,agendaDay'
      },
      events:'/office/project/{{ $group_projects->id }}/event',
      selectable:true,
      selectHelper: true,
      select:function(start, end, allDay)
      {
          var title = prompt('Event Title:');

          if(title)
          {
              var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
              var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

              $.ajax({
                  url:"/office/project/event",
                  type:"POST",
                  data:{
                      title: title,
                      start: start,
                      end: end,
                      type: 'add'
                  },
                  success:function(data)
                  {
                      calendar.fullCalendar('refetchEvents');
                      alert("Event Created Successfully");
                  }
              })
          }
      },
      editable:true,
      eventResize: function(event, delta)
      {
          var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
          var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
          var title = event.title;
          var id = event.id;
          $.ajax({
              url:"/office/project/event",
              type:"POST",
              data:{
                  title: title,
                  start: start,
                  end: end,
                  id: id,
                  type: 'update'
              },
              success:function(response)
              {
                  calendar.fullCalendar('refetchEvents');
                  alert("Event Updated Successfully");
              }
          })
      },
      eventDrop: function(event, delta)
      {
          var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
          var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
          var title = event.title;
          var id = event.id;
          $.ajax({
              url:"/office/project/event",
              type:"POST",
              data:{
                  title: title,
                  start: start,
                  end: end,
                  id: id,
                  type: 'update'
              },
              success:function(response)
              {
                  calendar.fullCalendar('refetchEvents');
                  alert("Event Updated Successfully");
              }
          })
      },

      eventClick:function(event)
      {
          if(confirm("Are you sure you want to remove it?"))
          {
              var id = event.id;
              $.ajax({
                  url:"/office/project/event",
                  type:"POST",
                  data:{
                      id:id,
                      type:"delete"
                  },
                  success:function(response)
                  {
                      calendar.fullCalendar('refetchEvents');
                      alert("Event Deleted Successfully");
                  }
              })
          }
      }
  });

  });
</script>

@endsection