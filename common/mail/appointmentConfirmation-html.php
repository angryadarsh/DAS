<?php
use yii\helpers\Html;

/** @var $appointment \common\models\Appointment */
?>

<h3>Appointment Confirmation</h3>

<p>Dear <?= Html::encode($appointment->user->username) ?>,</p>

<p>Your appointment has been successfully booked with Dr. <?= Html::encode($appointment->doctor->username) ?>.</p>

<p><strong>Date:</strong> <?= Yii::$app->formatter->asDate($appointment->appointment_date) ?><br>
<strong>Time:</strong> <?= $appointment->start_time ?> – <?= $appointment->end_time ?><br>
<strong>Clinic:</strong> <?= Html::encode($appointment->clinic->name) ?><br>
<strong>Price:</strong> ₹<?= $appointment->price ?></p>

<p>Thank you!</p>
