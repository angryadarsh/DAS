<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create Clinic';
$inputCss = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5";

?>
<section class="bg-white">
  <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
    <h2 class="mb-4 text-xl font-bold text-gray-900"><?= $this->title ?></h2>
    <?php $form = ActiveForm::begin(['id' => 'clinic-form']); ?>

      <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
        
        <div class="w-full">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
            <?= $form->field($model, 'name')->textInput(['class' => $inputCss ,'placeholder' => 'Name'])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="brand" class="block mb-2 text-sm font-medium text-gray-900">State</label>
            <?= $form->field($model, 'state')->dropDownList($states,['prompt' => 'Select State','class' => $inputCss ,'placeholder' => 'State'])->label(false) ?>

        </div>

        <div class="w-full">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">City</label>
            <?= $form->field($model, 'city')->dropDownList([],['prompt' => 'Select city','class' => $inputCss ,'placeholder' => 'City'])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Pincode</label>
          <?= $form->field($model, 'pincode')->textInput([ 'type' => 'number','class' => $inputCss ,'placeholder' => 'Pincode'])->label(false) ?>
        </div>

        <div class="w-full">
          <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
          <?= $form->field($model, 'address')->textarea(['class' => $inputCss ,'placeholder' => 'Address'])->label(false) ?>
        </div>
    </div>

    <?= Html::submitButton('Create Clinic', ['class' => 'inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-white bg-blue-600 rounded-lg focus:ring-4 focus:ring-blue-300 hover:bg-blue-700']) ?>

    <?php ActiveForm::end(); ?>

  </div>
</section>

<?php

$this->registerJs(<<<JS
    $("#clinic-state").on("change", function () {
        const stateCode = $(this).val();

        if (stateCode) {
            $.ajax({
                url: "/clinic/get-cities", 
                type: "POST",
                data: { state_code: stateCode },
                success: function (res) {
                    const \$cityDropdown = $("#clinic-city");
                    \$cityDropdown.empty().append('<option value="">Select City</option>');

                    $.each(res, function (key, value) {
                        \$cityDropdown.append($('<option>', {
                            value: value,
                            text: value
                        }));
                    });
                },
                error: function () {
                    alert("Failed to load cities.");
                }
            });
        }
    });
JS);
?>

