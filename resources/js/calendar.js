import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar'); // Replace with your element's ID
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth' // You can change the initial view as needed
    });

    calendar.render();
});