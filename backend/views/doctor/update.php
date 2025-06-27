<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


$this->title = 'Update Doctor Profile';
$this->params['breadcrumbs'][] = $this->title;
$inputCss = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5";

?>
<section class="bg-white">
  <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
    <h2 class="mb-4 text-xl font-bold text-gray-900"><?= \yii\helpers\Html::a('<-', ['index', 'id' => $model->id]) ?>&nbsp;&nbsp;&nbsp;<?= $this->title ?></h2>
    <?php $form = ActiveForm::begin(['id' => 'docter-form']); ?>

      <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
        
        <div class="w-full">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
          <?= $form->field($model->user, 'email')->textInput(['class' => $inputCss ,'placeholder' => 'Email','readonly' => true])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="brand" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
          <?= $form->field($model->user, 'username')->textInput(['class' => $inputCss ,'placeholder' => 'Username','readonly' => true])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Specialization</label>
          <?= $form->field($model, 'specialization')->textInput(['class' => $inputCss ,'placeholder' => 'specialization'])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Qualification</label>
          <?= $form->field($model, 'qualification')->textInput(['class' => $inputCss ,'placeholder' => 'Qualification'])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Experience (in years)</label>
          <?= $form->field($model, 'experience')->textInput(['type' => 'number','class' => $inputCss ,'placeholder' => 'experience'])->label(false) ?>
        </div>
    </div>
    <?= Html::submitButton('Update Doctor', ['class' => 'inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-white bg-blue-600 rounded-lg focus:ring-4 focus:ring-blue-300 hover:bg-blue-700']) ?>

    <?php ActiveForm::end(); ?>

  </div>
</section>

                
