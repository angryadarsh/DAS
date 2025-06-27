<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'My Appointments';
$this->params['breadcrumbs'][] = $this->title;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<div class="w-full bg-gray-100 dark:bg-white-900 px-2 pt-4">
    <div class="w-[calc(100%-5px)] mx-auto">
        
        <table id="appointment-list" class="display dataTable w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Doctor Name</th>
                    <th>Clinic Name</th>
                    <th>Appointment Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Duration Minutes</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $count = 0;
            foreach ($dataProvider->getModels() as $model): 
                $count ++;
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $model->user->username ?? 'N/A' ?></td>
                    <td><?= $model->doctor->username ?></td>
                    <td><?= $model->clinic->name ?></td>
                    <td><?= $model->appointment_date ?></td>
                    <td><?= $model->start_time ?></td>
                    <td><?= $model->end_time ?></td>
                    <td><?= $model->duration_minutes ?></td>
                    <td><?= $model->price ?></td>
                    <td><?= $model->status ?></td>
                    <td>
                       <div style="display: flex; gap: 10px; align-items: center;">
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/edit.png', ['alt' => 'Calender', 'style' => 'height:20px;']),
                                ['edit-appointment', 'id' => $model->id],
                                ['title' => 'Edit Appointment', 'data-pjax' => '0']
                            ) ?>
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/view.png', ['alt' => 'Link Clinic', 'style' => 'height:20px;']),
                                ['view-appointment', 'id' => $model->id],
                                ['title' => 'VIew Appointment', 'data-pjax' => '0']
                            ) ?>
                        </div>
                    </td>
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