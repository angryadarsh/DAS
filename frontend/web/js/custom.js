

// document.addEventListener('DOMContentLoaded', function() {
//     const calendarEl = document.getElementById('calendar')
//     const calendar = new FullCalendar.Calendar(calendarEl, {
//       initialView: 'timeGridWeek',
//       height: 'auto',
//       headerToolbar: {
//         left: 'prev,next today',  
//         center: 'title',
//         right: 'dayGridMonth,timeGridWeek,timeGridDay' // view switcher
//       },
//       slotDuration: "00:10:00",
//       slotMinTime: "10:00:00",
//       slotMaxTime: "21:00:00",
//       hiddenDays: [0,],
//       selectable: true,
//       allDaySlot: false,
//       events: '/appointment/get-booked-slots', // Load from backend
//       select: function (info) {
//         const start = new Date(info.startStr);
//         const end = new Date(info.endStr);

//         const dateOptions = { day: '2-digit', month: 'short', year: 'numeric' };
//         const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };

//         const formattedDate = start.toLocaleDateString('en-IN', dateOptions);
//         const formattedStartTime = start.toLocaleTimeString('en-IN', timeOptions);
//         const formattedEndTime = end.toLocaleTimeString('en-IN', timeOptions);

//         // Example Output: 24 Jun 2025, 10:00 AM – 10:30 AM
//         const rangeText = `${formattedDate}, ${formattedStartTime} – ${formattedEndTime}`;

//         // Set hidden inputs
//         document.getElementById('startTime').value = info.startStr;
//         document.getElementById('endTime').value = info.endStr;

//         // Show in modal
//         document.getElementById('displaySelectedTime').textContent = rangeText;

//         // Show modal
//         document.getElementById('bookingModal').classList.remove('hidden');
//       }
//     });
//     calendar.render()
//     // Handle modal close
//     document.getElementById('closeModal').addEventListener('click', () => {
//       document.getElementById('bookingModal').classList.add('hidden');
//     });

//     // Handle booking form submission
//     document.getElementById('bookingForm').addEventListener('submit', function (e) {
//       e.preventDefault();

//       const formData = new FormData(this);

//       axios.post('/appointment/book', {
//         doctor_id: 1, // Replace with actual doctor ID
//         user_id: 123, // Replace with actual user ID
//         start: formData.get('start'),
//         end: formData.get('end'),
//         patient_name: formData.get('patient_name'),
//         reason: formData.get('reason')
//       }).then(res => {
//         alert('Appointment booked successfully!');
//         document.getElementById('bookingModal').classList.add('hidden');
//         calendar.refetchEvents();
//       }).catch(err => {
//         alert('Booking failed. Try again.');
//       });
//     });
// })

    

document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
      document.querySelectorAll('.alert').forEach(function (el) {
        el.classList.remove('show');
        el.classList.add('fade');
        setTimeout(() => el.remove(), 500); // remove from DOM after fade
      });
    }, 3000); // 3 seconds
  });
