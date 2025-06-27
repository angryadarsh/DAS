<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

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
    <?php $this->head() ?>
</head>
<body class="flex flex-col min-h-screen">
<div class="flex flex-1 bg-gray-200">
<?php 
$this->beginBody(); 
    if (!Yii::$app->user->isGuest) {
        echo $this->render('_partials/_header');
    }
?>
<main role="main" class="flex-1 p-4 w-full">
    <div class="container pb-3 pt-5 px-4" style="background-color:rgb(255, 255, 255);">
      
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!-- <footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <? Html::encode(Yii::$app->name) ?> <? date('Y') ?></p>
        <p class="float-end"><? Yii::powered() ?></p>
    </div>
</footer> -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
