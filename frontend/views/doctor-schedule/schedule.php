<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DoctorSchedule;

/* @var $this yii\web\View */
/* @var $models DoctorSchedule[] */

$this->title = 'My Schedule';
?>
<?php $form = ActiveForm::begin(); ?>

<div class="grid gap-4 bg-white p-4 rounded-lg shadow">
  <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach ($models as $i => $model): ?>
        <div class="p-4 border rounded-lg">
            <h3 class="font-semibold mb-2">
                <?= DoctorSchedule::optsDayOfWeek()[$model->day_of_week] ?>
            </h3>

            <?= Html::activeHiddenInput($model, "[$i]day_of_week") ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?= $form->field($model, "[$i]start_time")
                        ->input('time', ['class' => 'w-full bg-gray-200'])
                        ->label('Start Time') ?>

                <?= $form->field($model, "[$i]end_time")
                        ->input('time', ['class' => 'w-full bg-gray-200'])
                        ->label('End Time') ?>
            </div>

            <?= $form->field($model, "[$i]is_holiday")
                    ->checkbox([], false)
                    ->label('Holiday') ?>
        </div>
    <?php endforeach; ?>
    <div class="mt-4">
        <?= Html::submitButton('Save Schedule', ['class' => 'px-4 py-2 bg-blue-600 text-white rounded']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

