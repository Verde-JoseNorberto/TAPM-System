@extends('layout.layFac')

@section('page-content')
<div class="container my-2">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id) }}">{{ __('Project') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active">{{ __('Events') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/progress') }}">{{ __('Progress') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('faculty/project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
    </li>
  </ul>
  <div class="card text-dark border-dark my-3">
    <div class="card-body">
      <h2>{{ $group_projects->title }}</h2>
      <strong>{{ __('Team:') }}</strong> {{ $group_projects->team }}<br>
      <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
      @if($group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'admin' || $group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'project_manager')
      <button class="btn btn-dark position-absolute top-0 end-0 my-3 mx-3" data-bs-toggle="modal" data-bs-target="#createEvent">
        {{ __('Add Event') }}</button>
      @endif
    </div>
  </div>
  <div id='calendar'></div>

  @include('faculty.edCal')

  <!-- Add Event -->
  <div class="modal fade" id="createEvent" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Create Event') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('faculty/event') }}">
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
                  <label class="form-label">{{ __('Description') }}</label>
                  <textarea id="description" class="form-control" rows="4" name="description"></textarea>
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Start') }}</label>
                  <input id="start" type="date" class="form-control" name="start">
                </div>
              </div>

              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('End') }}</label>
                  <input id="end" type="date" class="form-control" name="end">
                </div>
              </div>
            </div>

            <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">{{ __('Create Event') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  {{-- Scripts --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    $(document).ready(function () {
        var SITEURL = "{{ url('/') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            editable: true,
            events: SITEURL + "/faculty/project/{id}/event",
            displayEventTime: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            eventDrop: function (event, delta) {
                var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                $.ajax({
                    url: SITEURL + '/faculty/project/{id}/event',
                    data: {
                        title: event.event_name,
                        start: event_start,
                        end: event_end,
                        id: event.id,
                        type: 'edit'
                    },
                    type: "POST",
                });
            },
            eventClick: function (event) {
              $('#viewEventModal').modal('show');
              $.ajax({
                  url: SITEURL + '/faculty/project/{id}/event',
                  data: {
                      id: event.id,
                      type: 'fetch',
                  },
                  type: "GET",
                  success: function (response) {
                      var eventData = response.data;

                      $('.viewEventModalId').val(eventData.id);
                      $('.viewEventModalTitle').val(eventData.title);
                      $('.viewEventModalDescription').val(eventData.description);
                      $('.viewEventModalStart').val(eventData.start);
                      $('.viewEventModalEnd').val(eventData.end);
                  }
              });
          },
      });
  });
</script>
@endsection