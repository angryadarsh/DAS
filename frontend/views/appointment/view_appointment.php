
<div class="bg-white rounded-xl shadow-md overflow-hidden w-full md:w-[48%]">
        <div class="md:flex">
          <div class="md:flex-shrink-0">
            <img class="h-48 w-full object-cover md:w-48" src="<?= Yii::getAlias('@web') ?>/images/physician.png" alt="Doctor's image">
          </div>
          <div class="p-6">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Dr. <?= $appointment->doctor->username ?></div>
            <p class="mt-1 text-lg font-medium text-black">Specialty: <?= $appointment->doctorDetails->specialization ?></p>
            <p class="mt-2 text-gray-500">Booked on <?= Yii::$app->formatter->asDate($appointment->created_at) ?></p>
            <p class="mt-2 text-gray-500">Booking Date <?= $appointment->appointment_date ?></p>
            <p class="mt-2 text-gray-500">Start Time <?= $appointment->start_time ?></p>
            <p class="mt-2 text-gray-500">End Time <?= $appointment->end_time ?></p>
            <p class="mt-2 text-gray-500">Total Duration <?= $appointment->duration_minutes ?></p>
            <p class="mt-2 text-gray-500">Price <?= $appointment->price ?></p>
            <p class="mt-2 text-gray-500">Status <?= $appointment->displayStatus() ?></p>
          </div>
        </div>
      </div>