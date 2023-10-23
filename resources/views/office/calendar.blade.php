@extends('layout.layOff')

@section('content')
    <div id='calendar'></div>
    
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($events)
            });
            calendar.render();
        });
    </script>
@endsection
