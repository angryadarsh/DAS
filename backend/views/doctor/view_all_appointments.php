<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'All Doctors Appointment';
$this->params['breadcrumbs'][] = $this->title;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<div class="w-full bg-gray-100 dark:bg-white-900 px-2 pt-4">
    <div class="w-[calc(100%-5px)] mx-auto">
        
        <table id="appointment-list" class="display dataTable w-full">
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
            <tbody>
            <?php $count = 0;
            foreach ($appointments as $model):
                $count ++;
                ?>
                
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $model['doctor']['username'] ?? 'N/A' ?></td>
                    <td><?= $model['doctorDetails']['specialization'] ?? 'N/A' ?></td>
                    <td><?= $model['appointment_date'] ?? 'N/A' ?></td>
                    <td><?= $model['start_time'] ?? 'N/A' ?></td>
                    <td><?= $model['user']['username'] ?? 'N/A' ?></td>
                    <td><?= $model['status'] ?? 'N/A' ?></td>
                    
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>  
<?php 
$this->registerJs('
    $(document).ready(function() {
        $("#appointment-list").DataTable();
    })
    
'); ?>