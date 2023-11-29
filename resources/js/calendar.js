import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: '/calendar/events',
        eventClick: function (info) {
            $('#viewEventModal').modal('show');
            $('#viewEventModalTitle').html(info.event.title);
            $('#viewEventModalDescription').html(info.event.extendedProps.description);
            $('#viewEventModalStart').html(info.event.start.toISOString().substring(0, 10));
            $('#viewEventModalEnd').html(info.event.end.toISOString().substring(0, 10));
        },
        dateClick: function (info) {
            $('#createEventModal').modal('show');
            $('#createEventModalStart').val(info.dateStr);
        }
    });

    calendar.render();
});
