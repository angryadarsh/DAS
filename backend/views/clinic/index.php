<?php
use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'Clinic List';
?>

<h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"><?= $this->title ?></h2>

<div class="d-flex justify-content-end mb-3">
   <?php echo Html::a('Create Clinic', ['create'], ['class' => 'btn btn-success text-right']); ?>
</div
<?php   
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'address:ntext',
        'city',
        'state',
        'pincode',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        
    ],
]);
?>
