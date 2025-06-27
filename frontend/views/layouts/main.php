<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php $this->head() ?>
</head>
<body class="flex flex-col min-h-screen">
<div class="flex flex-1 bg-gray-200">

<?php $this->beginBody(); 

    if (!Yii::$app->user->isGuest) {
        echo $this->render('_partials/_header');
    }

?>

    <main role="main" class="flex-1 p-4">
        <div class="container">
        <?php  if (!Yii::$app->user->isGuest)
                  Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) 
            ?>
            <?= Alert::widget() ?>
        
            
            <?= $content ?>
        </div>
    </main>
</div>

<?php
if (!Yii::$app->user->isGuest) {
         $this->render('_partials/_footer');
   }
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
