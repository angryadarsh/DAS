<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FullCalendarAsset extends AssetBundle
{
    public $css = [
       
    ];

    public $js = [
       'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}