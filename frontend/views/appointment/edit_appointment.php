<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Update Appointment';
$this->params['breadcrumbs'][] = $this->title;

$inputCss = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5";
?>

<section class="bg-white px-4 py-6">
    <h2 class="mb-4 text-xl font-bold text-gray-900"><?= Html::encode($this->title) ?></h2>
    
    <?php $form = ActiveForm::begin(['id' => 'docter-form']); ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <!-- Left: Form -->
        <div class="space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900">Clinic</label>
                <?= $form->field($appointment, 'clinic_id')
                    ->dropDownList($clinic, [
                        'prompt' => 'Select Clinic',
                        'class' => $inputCss,
                    ])->label(false) ?>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900">Doctor</label>
                <?= $form->field($appointment, 'doctor_id')
                    ->dropDownList($doctors, [
                        'prompt' => 'Select Doctor',
                        'class' => $inputCss,
                    ])->label(false) ?>
            </div>
            <div  id="appintmentFormWrapper">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900">Date</label>
                    <?= $form->field($appointment, 'appointment_date')
                        ->input('date',[
                            'placeholder' => 'Select Date',
                            'class' => $inputCss,
                            'readonly' => true,
                        ])->label(false) ?>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900">Start Time</label>
                    <?= $form->field($appointment, 'start_time')
                        ->input('time', [
                            'placeholder' => 'Select Time',
                            'class' => $inputCss,
                            'readonly' => true,
                        ])->label(false) ?>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900">End Time</label>
                    <?= $form->field($appointment, 'end_time')
                        ->input('time', [
                            'placeholder' => 'Select Time',
                            'class' => $inputCss,
                            'readonly' => true,
                        ])->label(false) ?>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900">Duration Minutes</label>
                    <?= $form->field($appointment, 'duration_minutes')
                        ->textInput([
                            'class' => $inputCss,
                            'readonly' => true,
                        ])->label(false) ?>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900">Price</label>
                    <?= $form->field($appointment, 'price')
                        ->textInput([
                            'type' => 'number',
                            'class' => $inputCss,
                            'readonly' => true,
                        ])->label(false) ?>
                </div>
                <div>
                    <?= Html::submitButton('Book Appointment', [
                        'class' => 'mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'
                    ]) ?>
                </div>
            </div>
        </div>

        <!-- Right: Calendar -->
        <div  id="calendarWrapper">
            <?= $this->render('_calendar',['doctor_id'=>$doctor_id,'days'=>$days]) ?>
        </div>

    <?php ActiveForm::end(); ?>
</section>

<?php
$doctorUrl = \yii\helpers\Url::to(['appointment/get-doctors-by-clinic']);
$doctorScheduleUrl = \yii\helpers\Url::to(['appointment/get-doctor-schedule']);

$script = <<<JS
const scheduleUrl = '$doctorScheduleUrl';


$('#appointment-clinic_id').on('change', function() {
    let clinicId = $(this).val();
    let doctorSelect = $('#appointment-doctor_id');
    doctorSelect.html('<option>Loading...</option>');

    if (!clinicId) {
        doctorSelect.html('<option value="">Select Doctor</option>');
        return;
    }

    $.getJSON('$doctorUrl', {clinicId: clinicId}, function(data) {
        let options = '<option value="">Select Doctor</option>';
        $.each(data, function(id, username) {
            options += `<option value="\${id}">\${username}</option>`;
        });
        doctorSelect.html(options);
    });
});

let calendarRendered = false;

$('#appointment-doctor_id').on('change', function() {
    const doctorId = $(this).val();
    if (!doctorId) return;

    // Fetch doctor's schedule from backend
    $.getJSON(scheduleUrl, { id: doctorId }, function(schedule) {
        const calendarEl = document.getElementById('calendar');
        calendarEl.dataset.details = JSON.stringify(schedule);
        calendarEl.dataset.id = doctorId;

        // Parse schedule and build FullCalendar
        const dayMap = { Mon: 1, Tue: 2, Wed: 3, Thu: 4, Fri: 5, Sat: 6, Sun: 0 };
        const hiddenDays = [];
        let minTime = "23:59:59";
        let maxTime = "00:00:00";

        Object.entries(schedule).forEach(([day, [start, end, isHoliday]]) => {
            const index = dayMap[day];
            if (isHoliday || !start || !end) {
                hiddenDays.push(index);
            } else {
                if (start < minTime) minTime = start;
                if (end > maxTime) maxTime = end;
            }
        });

        // Destroy existing calendar 
        if (window.calendar) {
            window.calendar.destroy();
        }

        window.calendar = new FullCalendar.Calendar(calendarEl, {
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
            events: '/appointment/get-booked-slots?id=' + doctorId,

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
                    let hour = String(date.getHours()).padStart(2, '0');
                    let minutes = String(date.getMinutes()).padStart(2, '0');
                    return hour+':'+minutes;
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
            }
        });

        $('#calendarWrapper').removeClass('hidden');
        $('#appintmentFormWrapper').removeClass('hidden');
        window.calendar.render();
    });
});

JS;

$this->registerJs($script);
?>
