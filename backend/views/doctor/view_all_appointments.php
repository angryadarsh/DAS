<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'All Doctors Appointment';
$this->params['breadcrumbs'][] = $this->title;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<div class="w-full bg-gray-100 dark:bg-white-900 px-2 pt-4">
    <div class="w-[calc(100%-5px)] mx-auto">
        
        <table id="patient-list" class="display dataTable w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Doctor Name</th>
                    <th>Specialty</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            
        </table>
    </div>
</div>  
<?php 
$this->registerJs('
    $(document).ready(function() {
        $("#patient-list").DataTable();
    })
    
'); ?>