<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


$this->title = 'Appointment Calendar';
$this->params['breadcrumbs'][] = $this->title;

?>
 <div id="calendar" data-details='<?= json_encode($days) ?>' data-id="<?= $id ?>"></div>
 

 