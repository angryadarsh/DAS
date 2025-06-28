<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = UCFirst($user->username) . '`s Appointment';
$this->params['breadcrumbs'][] = $this->title;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<!-- Full width wrapper -->
<div class="w-full px-4 pt-4">
  <!-- Flex container for 2 cards per row -->
  <div class="flex flex-wrap gap-6 justify-start">
    
    <?php foreach ($appointments as $key => $value) {
     
    ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden w-full md:w-[48%]">
        <div class="md:flex">
          <div class="md:flex-shrink-0">
            <img class="h-48 w-full object-cover md:w-48" src="<?= Yii::getAlias('@web') ?>/images/physician.png" alt="Doctor's image">
          </div>
          <div class="p-6">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Dr. <?= $value['doctor']['username'] ?></div>
            <p class="mt-1 text-lg font-medium text-black">Specialty: <?= $value['doctorDetails']['specialization'] ?></p>
            <p class="mt-2 text-gray-500">Booked on <?= Yii::$app->formatter->asDate($value['created_at']) ?></p>
            <p class="mt-2 text-gray-500">Booking Date <?= $value['appointment_date'] ?></p>
            <p class="mt-2 text-gray-500">Start Time <?= $value['start_time'] ?></p>
            <p class="mt-2 text-gray-500">End Time <?= $value['end_time'] ?></p>
            <p class="mt-2 text-gray-500">Total Duration <?= $value['duration_minutes'] ?></p>
            <p class="mt-2 text-gray-500">Price <?= $value['price'] ?></p>
            <p class="mt-2 text-gray-500">Status <?= $value['status'] ?></p>
          </div>
        </div>
      </div>
    <?php }?>

  </div>
</div>