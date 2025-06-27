
<div id="calendar"></div>


<script>
  var calendar ;
   document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar')
     calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      height: 'auto',
      headerToolbar: {
        left: 'prev,next today',  
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay' // view switcher
      },
      slotDuration: "00:10:00",
      slotMinTime: "10:00:00",
      slotMaxTime: "21:00:00",
      hiddenDays: [0,],
      selectable: true,
      allDaySlot: false,
      events: '/appointment/get-booked-slots', // Load from backend
      
      selectAllow: function(selectInfo) {
        const now = new Date();

        return selectInfo.start >= now;
      },
      select: function (info) {
            const start = new Date(info.startStr);
            const end = new Date(info.endStr);
            const formattedDateForInput = start.toISOString().slice(0, 10);

            // Helper to format HH:mm
            function formatTimeForInput(date) {
              let hours = String(date.getHours()).padStart(2, '0');
              let minutes = String(date.getMinutes()).padStart(2, '0');
              return `${hours}:${minutes}`;
            }

            // Duration
            const durationInMinutes = Math.round((end - start) / (1000 * 60));

            // Pricing logic
            let totalPrice = 0;
            let temp = new Date(start);
            while (temp < end) {
              const blockStart = new Date(temp);
              temp.setMinutes(temp.getMinutes() + 10);
              const blockEnd = new Date(Math.min(temp.getTime(), end.getTime()));

              // Only count full 10-minute blocks
              const blockDuration = (blockEnd - blockStart) / (1000 * 60);
              if (blockDuration < 10) continue;

              const day = blockStart.getDay(); 
              const hour = blockStart.getHours();
              const minute = blockStart.getMinutes();

              const isWeekday = day >= 1 && day <= 5;
              const isInRange =
                (hour > 10 && hour < 19) ||
                (hour === 10 && minute >= 0) ||
                (hour === 19 && minute === 0); // 19:00 exactly

              totalPrice += (isWeekday && isInRange) ? 100 : 300;
            }
              
            // Update input fields
            document.getElementById('appointment-appointment_date').value = formattedDateForInput;
            document.getElementById('appointment-start_time').value = formatTimeForInput(start);
            document.getElementById('appointment-end_time').value = formatTimeForInput(end);
            document.getElementById('appointment-duration_minutes').value = durationInMinutes;
            document.getElementById('appointment-price').value = totalPrice;
            $('#appintmentFormWrapper').removeClass('hidden');


      }
    });
    calendar.render()
    
})

</script>