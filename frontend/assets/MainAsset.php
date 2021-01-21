<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Главные зависимости сайта.
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    /**
     * @var string[] Ключ - полноценный файл, значение - минифицированный.
     * Если файл имеет только минифицированную версию - необходимо дублировать.
     */
    public $cssFiles = [
        'css/main_style.css' => 'css/main_style.min.css',
        'css/style.css' => 'css/style.min.css',
        'font-awesome-4.7.0/css/font-awesome.min.css' => 'font-awesome-4.7.0/css/font-awesome.min.css',
        'js/select2/select2.min.css' => 'js/select2/select2.min.css',
        'css/bootstrap-grid.min.css' => 'css/bootstrap-grid.min.css',
        'js/slick/slick.css' => 'js/slick/slick.min.css',
        'css/back-styles.css' => 'css/back-styles.min.css',
    ];

    /**
     * @var string[] Ключ - полноценный файл, значение - минифицированный.
     * Если файл имеет только минифицированную версию - необходимо дублировать.
     */
    public $jsFiles = [
        'js/resizeSensor.js' => 'js/resizeSensor.min.js',
        'js/jquery.sticky-kit.js' => 'js/jquery.sticky-kit.min.js',
        'js/slick/slick.min.js' => 'js/slick/slick.min.js',
        'js/select2/select2.min.js' => 'js/select2/select2.min.js',
        'js/script.js' => 'js/script.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        $this->css = $this->getVersionedFiles($this->cssFiles);
        $this->js = $this->getVersionedFiles($this->jsFiles);

        parent::init();
    }

    /**
     * Если окружение prod используем минифицированные файлы
     * Для минификации файлов используется команда php yii minify
     * В остальных случаях используем обычные файлы
     * @param array $files
     * @return array
     */
    public function getVersionedFiles(array $files): array
    {
        if (YII_ENV === 'prod') {
            $out = [];
            foreach ($files as $file) {
                $filePath = \Yii::getAlias('@webroot/' . $file);
                $out[] = $file . (is_file($filePath) ? '?v='.filemtime($filePath) : '');
            }
        } else {
            $out = array_keys($files);
        }
        return $out;
    }
}
