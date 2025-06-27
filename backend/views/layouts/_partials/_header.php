<?php
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Html;
?>
<header>
	<aside
		class="flex flex-col items-center bg-white text-gray-700 shadow sticky top-0 h-screen">
		<!-- Side Nav Bar-->

		<div class="h-16 flex items-center w-full">
			<!-- Logo Section -->
			<a class="h-6 w-6 mx-auto" href="<?= \yii\helpers\Url::to(['site/index']) ?>">
				<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/stethoscope.png"
					alt="svelte logo" />
			</a>
		</div>

		<ul>
			<!-- Items Section -->
			<li class="hover:bg-gray-100">
				<a
					href="<?= \yii\helpers\Url::to(['site/dashboard']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="Dashboard">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/dashboard.png"
					alt="dashboard" />

				</a>
			</li>
			<li class="hover:bg-gray-100" >
				<a
					href="<?= \yii\helpers\Url::to(['clinic/index']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="Clinic">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/clinic.png"
					alt="Clinic" />
                    
				</a>
			</li>
			<li class="hover:bg-gray-100" >
				<a
					href="<?= \yii\helpers\Url::to(['doctor/index']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="Docters">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/doctor.png"
					alt="Doctor" />
                    
				</a>
			</li>
			<li class="hover:bg-gray-100" >
				<a
					href="<?= \yii\helpers\Url::to(['patient/index']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="Patients">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/fever.png"
					alt="Doctor" />
                    
				</a>
			</li>
			<li class="hover:bg-gray-100" >
				<a
					href="<?= \yii\helpers\Url::to(['doctor/view-all-appointments']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="Appointments">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/schedule.png"
					alt="Appointments" />
                    
				</a>
			</li>
        </ul>

		<div class="mt-auto h-16 flex items-center w-full">
			<!-- Action Section -->
            
			<button
				class="h-16 w-10 mx-auto flex flex justify-center items-center
				w-full focus:text-orange-500 hover:bg-red-200 focus:outline-none" title="Logout">
                 <a class="h-6 w-6 mx-auto hover:bg-red-200" href="<?= \yii\helpers\Url::to(['site/logout']) ?>">
				<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/logout.png"
					alt="logout logo" />
			</a>
			</button>
		</div>

	</aside>
<!-- </div> -->
</header>