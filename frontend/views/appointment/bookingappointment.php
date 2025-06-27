<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Book Appointment';
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
                    ->dropDownList([], [
                        'prompt' => 'Select Doctor',
                        'class' => $inputCss,
                    ])->label(false) ?>
            </div>
            <div class = "hidden" id="appintmentFormWrapper">
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
        <div class="hidden" id="calendarWrapper">
            <?= $this->render('_calendar') ?>
        <!-- </div> -->
    </div>

    <?php ActiveForm::end(); ?>
</section>

<?php
$doctorUrl = \yii\helpers\Url::to(['appointment/get-doctors-by-clinic']);

$script = <<<JS
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
    $('#calendarWrapper').removeClass('hidden');

    if (typeof calendar !== 'undefined') {
        if (!calendarRendered) {
            calendar.render();
            calendarRendered = true;
        } else {
            calendar.updateSize();
        }
    }
});
JS;

$this->registerJs($script);
?>
