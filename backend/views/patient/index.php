<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Patient List';
$this->params['breadcrumbs'][] = $this->title;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<div class="w-full bg-gray-100 dark:bg-white-900 px-2 pt-4">
    <div class="w-[calc(100%-5px)] mx-auto">
        
        <table id="patient-list" class="display dataTable w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
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
                    <td><?= $model->username ?? 'N/A' ?></td>
                    <td><?= $model->email ?></td>
                    <td><?= $model->role ?></td>
                    <td>
                       <div style="display: flex; gap: 10px; align-items: center;">
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/view.png', ['alt' => 'View', 'style' => 'height:20px;']),
                                ['view-appointments', 'id' => $model->id],
                                ['title' => 'Appointments', 'data-pjax' => '0']
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
        $("#patient-list").DataTable();
    })
    
'); ?>