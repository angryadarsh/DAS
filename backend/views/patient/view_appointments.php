<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = UCFirst($model->username) . '`s Appointment';
$this->params['breadcrumbs'][] = $this->title;
// echo "<pre>"; print_r($model); exit;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<!-- Full width wrapper -->
<div class="w-full px-4 pt-4">
  <!-- Flex container for 2 cards per row -->
  <div class="flex flex-wrap gap-6 justify-start">
    
    <?php for ($i = 0; $i < 4; $i++): ?>
      <!-- Each card takes 100% on small screens, 48% (approx) on md+ -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden w-full md:w-[48%]">
        <div class="md:flex">
          <div class="md:flex-shrink-0">
            <img class="h-48 w-full object-cover md:w-48" src="<?= Yii::getAlias('@web') ?>/images/physician.png" alt="Doctor's image">
          </div>
          <div class="p-6">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Dr. John Doe</div>
            <p class="mt-1 text-lg font-medium text-black">Specialty: Cardiology</p>
            <p class="mt-2 text-gray-500">Available Time Slots:</p>
            <ul class="list-disc list-inside space-y-1 text-sm">
              <li>10:00 - 11:00</li>
              <li>13:00 - 14:00</li>
              <li>16:00 - 17:00</li>
            </ul>
            <button class="mt-4 w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
              Book Appointment
            </button>
          </div>
        </div>
      </div>
    <?php endfor; ?>

  </div>
</div>