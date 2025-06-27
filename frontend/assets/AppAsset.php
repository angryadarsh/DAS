<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/tailwindcss.css',
        'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css',
    ];
    public $js = [
        'js/custom.js',
        'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'frontend\assets\FullCalendarAsset'
    ];
}

