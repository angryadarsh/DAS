<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css',
        'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css',
        // 'css/datatable.css'
    ];
    public $js = [
        'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js',
        'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js',
        'js/calender.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'frontend\assets\FullCalendarAsset'
    ];
}
