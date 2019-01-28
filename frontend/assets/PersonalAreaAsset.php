<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
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
        'node_modules/jquery/dist/jquery.min.js',
        'js/misc.js',
        'js/material.js',
    ];
    public $depends = [
    ];
}
