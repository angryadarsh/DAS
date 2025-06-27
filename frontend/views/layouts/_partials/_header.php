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
					href="<?= \yii\helpers\Url::to(['appointment/index']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="My Appointments">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/calendar.png"
					alt="Appointment" />
                    
				</a>
			</li>
			<li class="hover:bg-gray-100" >
				<a
					href="<?= \yii\helpers\Url::to(['appointment/book-appointment']) ?>"
					class="h-16 px-6 flex flex justify-center items-center w-full
					focus:text-orange-500" title="Book Appointment">
					<img
					class="h-6 w-6 mx-auto"
					src="<?= Yii::getAlias('@web') ?>/images/timesheet.png"
					alt="Appointment" />
                    
				</a>
			</li>
        </ul>
		
		<div class="mt-auto flex flex-col items-center w-full">
			<!-- New Action Button Section (e.g., Settings) -->
		<?php if (Yii::$app->user->can('doctor')): ?>
			<div class="h-16 w-full flex items-center justify-center hover:bg-gray-100">
				<a
					class="h-6 w-6 mx-auto"
					href="<?= \yii\helpers\Url::to(['doctor-schedule/schedule']) ?>"
					title="Settings">
					<img
						class="h-6 w-6 mx-auto"
						src="<?= Yii::getAlias('@web') ?>/images/setting.png"
						alt="settings" />
				</a>
			</div>
		<?php endif; ?>
			<div class="h-16 w-full flex items-center justify-center hover:bg-red-200">
				<a
					class="h-6 w-6 mx-auto"
					href="<?= \yii\helpers\Url::to(['site/logout']) ?>"
					title="Logout">
					<img
						class="h-6 w-6 mx-auto"
						src="<?= Yii::getAlias('@web') ?>/images/logout.png"
						alt="logout logo" />
				</a>
			</div>
		</div>


	</aside>
<!-- </div> -->
</header>