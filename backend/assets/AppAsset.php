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
        'css/mobile.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery.cookie.js',
        'js/plugins/datepicker/bootstrap-datepicker.js',
        'js/plugins/timepicker/bootstrap-timepicker.min.js',
        'js/script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
