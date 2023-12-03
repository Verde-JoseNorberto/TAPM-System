@extends('layout.layOff')

@section('page-content')
<div class="container my-2">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id) }}">{{ __('Updates') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/task') }}">{{ __('Taskboard') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active">{{ __('Events') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/progress') }}">{{ __('Progress') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ URL::to('office/project/' . $group_projects->id . '/team') }}">{{ __('Team') }}</a>
    </li>
  </ul>
  <div class="card text-dark border-dark my-3">
    <div class="card-body">
      <h2>{{ $group_projects->team }}</h2>
      <strong>{{ __('Project Title:') }}</strong> {{ $group_projects->title }}<br>
      <strong>{{ __('Advisor:') }}</strong> {{ $group_projects->advisor }}
      @if($group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'admin' || $group_projects->members->where('user_id', auth()->user()->id)->first()->role == 'project_manager')
      <button class="btn btn-dark position-absolute top-0 end-0 my-3 mx-3" data-bs-toggle="modal" data-bs-target="#createEvent">
        {{ __('Add Event') }}</button>
      @endif
    </div>
  </div>
  <div id='calendar'></div>

  <!-- View Event Modal -->
  <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Event Details') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5>Title: <span id="viewEventModalTitle"></span></h5>
          <p>Description: <span id="viewEventModalDescription"></span></p>
          <p>Start Date: <span id="viewEventModalStart"></span></p>
          <p>End Date: <span id="viewEventModalEnd"></span></p>
        </div>
        <div class="modal-footer">
          <button id="deleteEventBtn" type="button" class="btn btn-danger">{{ __('Delete Event') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Event --}}
  <div class="modal fade" id="deleteEvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{__('Delete Task')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('office/event') }}">
            @csrf
            @method("DELETE")
            <h4>Are you sure you want to Delete Event?</h4>
            <input type="hidden" name="id" id="deleteEventId">
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">{{ __('Delete Task') }}</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            </form>
          </div>
          </div>
      </div>
    </div>
  </div>

  <!-- Add Event -->
  <div class="modal fade" id="createEvent" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Create Event') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('office/event') }}">
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
            events: {
                url: SITEURL + "/office/project/{{ $group_projects->id }}/event",
                type: 'GET',
                data: {
                    group_project_id: {{ $group_projects->id }}
                },
                error: function () {
                    alert('Error fetching events');
                }
            },
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
                    url: SITEURL + '/office/project/{{ $group_projects->id }}/event',
                    data: {
                        title: event.title,
                        description: event.description,
                        start: event_start,
                        end: event_end,
                        id: event.id,
                        group_project_id: {{ $group_projects->id }},
                        type: 'update'
                    },
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        var eventData = response.data;
                        $('#viewEventModalId').html(eventData.id);
                        $('#viewEventModalTitle').html(eventData.title);
                        $('#viewEventModalDescription').html(eventData.description);
                        $('#viewEventModalStart').html(eventData.start);
                        $('#viewEventModalEnd').html(eventData.end);
                    }
                });
            },
            eventClick: function (event) {
                $('#viewEventModal').modal('show');
                var eventIdToDelete = event.id; // Store the event ID in a variable

                $.ajax({
                    url: SITEURL + '/office/project/{{ $group_projects->id }}/event',
                    data: {
                        id: event.id,
                        group_project_id: {{ $group_projects->id }},
                        type: 'fetch',
                    },
                    type: "GET",
                    success: function (response) {
                        var eventData = response.data;

                        $('#viewEventModalId').html(eventData.id);
                        $('#viewEventModalTitle').html(eventData.title);
                        $('#viewEventModalDescription').html(eventData.description);
                        $('#viewEventModalStart').html(eventData.start);
                        $('#viewEventModalEnd').html(eventData.end);
                    }
                });

                // Use eventIdToDelete when the "Delete Event" button is clicked
                $('#deleteEventBtn').off('click').on('click', function () {
                    console.log('Event ID to delete:', eventIdToDelete);
                    $('#deleteEventId').val(eventIdToDelete);
                    $('#deleteEventModal').modal('show');
                });
            },
        });
    });
</script>
@endsection