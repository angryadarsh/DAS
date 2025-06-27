<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Doctor List';
$this->params['breadcrumbs'][] = $this->title;
?>
 <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>
<div class="w-full bg-gray-100 dark:bg-white-900 px-2 pt-4">
    <div class="w-[calc(100%-5px)] mx-auto">
        
        <table id="example" class="display dataTable w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Specialization</th>
                    <th>Qualification</th>
                    <th>Experience</th>
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
                    <td><?= $model->specialization ?></td>
                    <td><?= $model->qualification ?></td>
                    <td><?= $model->experience ?></td>
                    
                    <td>
                       <div style="display: flex; gap: 10px; align-items: center;">
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/calender.png', ['alt' => 'Calender', 'style' => 'height:20px;']),
                                ['view-calender', 'id' => $model->id],
                                ['title' => 'Calender', 'data-pjax' => '0']
                            ) ?>
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/link.png', ['alt' => 'Link Clinic', 'style' => 'height:20px;']),
                                ['link-clinic', 'id' => $model->id],
                                ['title' => 'Link Clinic', 'data-pjax' => '0']
                            ) ?>
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/view.png', ['alt' => 'View', 'style' => 'height:20px;']),
                                ['view', 'id' => $model->id],
                                ['title' => 'View', 'data-pjax' => '0']
                            ) ?>
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/edit.png', ['alt' => 'Update', 'style' => 'height:20px;']),
                                ['update', 'id' => $model->id],
                                ['title' => 'Update', 'data-pjax' => '0']
                            ) ?>
                            <?= \yii\helpers\Html::a(
                                \yii\helpers\Html::img('@web/images/delete.png', ['alt' => 'Delete', 'style' => 'height:20px;']),
                                ['delete', 'id' => $model->id],
                                [
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure you want to delete this?',
                                    'title' => 'Delete',
                                    'data-pjax' => '0'
                                ]
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
$add = Yii::getAlias('@web') . '/images/add-button.png';
$this->registerJs('
    $(document).ready(function() {
        $("#example").DataTable();
    })
    $("#example").DataTable({
        dom: \'<"top"lfB>rt<"bottom"ip><"clear">\',
        initComplete: function () {
            $("div.dataTables_filter").append(
                \'<button class="ml-4 px-3 py-1" id="addDoctorBtn" title="Add Doctor"><img class="h-6 w-6 mx-auto" src="' . $add . '" alt="Appointment" /></button>\'
            );

            $("#addDoctorBtn").on("click", function() {
                window.location.href = "' . \yii\helpers\Url::to(['create']) . '";
                // alert("doctor created");
            });
        }
    });
'); ?>