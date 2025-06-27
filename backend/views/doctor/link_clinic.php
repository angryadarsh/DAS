<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


$this->title = 'Link Clinic';
$this->params['breadcrumbs'][] = $this->title;
$inputCss = "w-full";
?>
<section class="bg-white">
  <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
    <h2 class="mb-4 text-xl font-bold text-gray-900"><?= \yii\helpers\Html::a('<-', ['index']) ?>&nbsp;&nbsp;&nbsp;<?= $this->title ?></h2>
    <?php $form = ActiveForm::begin(['id' => 'docter-form']); ?>

    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
        
        <div class="w-full">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Clinics </label>
          <?= $form->field($model, 'clinic_id')->dropdownList($clinic,['class' => $inputCss ,'placeholder' => 'Clinics','multiple' => true])->label(false) ?>
        </div>
    </div>

    
     <?= Html::submitButton('Update Clinic', ['class' => 'inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-white bg-blue-600 rounded-lg focus:ring-4 focus:ring-blue-300 hover:bg-blue-700']) ?>

    <?php ActiveForm::end(); ?>

  </div>
</section>
<?php
  $this->registerJs(<<<JS
    new TomSelect("#doctorclinic-clinic_id", {
        plugins: ['remove_button', 'checkbox_options'],
        create: false,
        allowEmptyOption: true
    });
  JS);
?>