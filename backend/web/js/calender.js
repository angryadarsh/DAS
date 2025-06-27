document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const config = JSON.parse(calendarEl.dataset.details);
    const id = calendarEl.dataset.id;

    // Days mapping for FullCalendar
    const dayMap = {
      sun: 0,
      mon: 1, 
      tue: 2, 
      wed: 3, 
      thu: 4, 
      fri: 5, 
      sat: 6
    };
    const dayHours = {};
    // Determine working days & calculate min/max time
    const hiddenDays = [];
    let minTime = "23:59:59";
    let maxTime = "00:00:00";

    Object.entries(config).forEach(([dayRaw, [start, end, isholiday]]) => {
      const day = dayRaw.toLowerCase();
        const dayIndex = dayMap[day];
        if (isholiday === 1 || !start || !end) {
            hiddenDays.push(dayIndex);
        } else {
           dayHours[dayIndex] = { start, end };
            // Adjust global min/max if needed
            if (start < minTime) minTime = start;
            if (end > maxTime) maxTime = end;
        }
    });

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotDuration: "00:10:00",
        slotMinTime: minTime,
        slotMaxTime: maxTime,
        hiddenDays: hiddenDays,
        selectable: true,
        allDaySlot: false,
        events: '/doctor/get-booked-slots?id=' + id,
        
    });

    calendar.render();
});