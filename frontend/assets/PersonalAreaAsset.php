<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Зависимости личного кабинета.
 */
class PersonalAreaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'node_modules/mdi/css/materialdesignicons.min.css',
        'css/style.css'
    ];

    public $js = [
        'node_modules/material-components-web/dist/material-components-web.min.js',
        'js/misc.js',
        'js/material.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
