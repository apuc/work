<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Главные зависимости сайта.
 */
class MainPageAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    /**
     * @var string[] Ключ - полноценный файл, значение - минифицированный.
     * Если файл имеет только минифицированную версию - необходимо дублировать.
     */
    public $cssFiles = [
//        'css/main_style.css' => 'css/main_style.min.css',
        'css/main_page/header.css' => 'css/main_page/header.css',
        'css/main_page/global.css' => 'css/main_page/global.css',
        'css/main_page/home-page.css' => 'css/main_page/home-page.css',
        'css/main_page/font.css' => 'css/main_page/font.css',
        'css/main_page/modal.css' => 'css/main_page/modal.css',
        'css/main_page/style.css' => 'css/main_page/style.css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css',
        'https://unpkg.com/swiper/swiper-bundle.min.css' => 'https://unpkg.com/swiper/swiper-bundle.min.css',
    ];

    /**
     * @var string[] Ключ - полноценный файл, значение - минифицированный.
     * Если файл имеет только минифицированную версию - необходимо дублировать.
     */
    public $jsFiles = [
        'https://unpkg.com/swiper/swiper-bundle.min.js' => 'https://unpkg.com/swiper/swiper-bundle.min.js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
        'js/script.js' => 'js/script.min.js',
        'js/sliderHomePage.js' => 'js/resizeSensor.min.js',
        'js/classie.js' => 'js/classie.js',
        'js/demo.js' => 'js/demo.js',
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
