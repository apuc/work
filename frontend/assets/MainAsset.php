<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $cssFiles = [
        'css/main_style.min.css',
        'css/style.min.css',
        'font-awesome-4.7.0/css/font-awesome.min.css',
        'js/select2/select2.min.css',
        'css/bootstrap-grid.min.css',
        'js/slick/slick.min.css',
        'css/back-styles.min.css',
    ];
    public $jsFiles = [
        'js/resizeSensor.js',
        'js/jquery.sticky-kit.min.js',
        'js/slick/slick.min.js',
        'js/select2/select2.min.js',
        'js/script.min.js',
        //'https://vk.com/js/api/openapi.js?165',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->css = $this->getVersionedFiles($this->cssFiles);
        $this->js = $this->getVersionedFiles($this->jsFiles);

        parent::init();
    }

    public function getVersionedFiles($files)
    {
        $out = [];

        foreach ($files as $file) {
            $filePath = \Yii::getAlias('@webroot/' . $file);
            $out[] = $file . (is_file($filePath) ? '?v='.filemtime($filePath) : '');
        }

        return $out;
    }
}
