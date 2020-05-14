<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;
use MatthiasMullie\Minify;

class MinifyController extends Controller
{
    public static $JS = [
        "@frontend/web/js/script.js",
        "@frontend/web/js/resizeSensor.js",
        "@frontend/web/js/resume_search.js",
        "@frontend/web/js/vacancy_search.js",
        "@frontend/web/js/jquery.sticky-kit.js",
    ];
    public static $CSS = [
        "@frontend/web/css/main_style.css",
        "@frontend/web/css/back-styles.css",
        "@frontend/web/css/style.css",
        "@frontend/web/js/slick/slick.css",
    ];
    public function actionIndex() {
        echo "====================== JS files ================================================\n";
        foreach (self::$JS as $js) {
            $path_to = str_replace('.js', '.min.js', $js);
            $this->minifyJS(Yii::getAlias($js), Yii::getAlias($path_to));
            echo "$js--->$path_to\n";
        }
        echo "====================== CSS files ===============================================\n";
        foreach (self::$CSS as $css) {
            $path_to = str_replace('.css', '.min.css', $css);
            $this->minifyCSS(Yii::getAlias($css), Yii::getAlias($path_to));
            echo "$css--->$path_to\n";
        }
    }
    public function minifyJS($sourcePath, $minifiedPath) {
        (new Minify\JS($sourcePath))->minify($minifiedPath);
    }
    public function minifyCSS($sourcePath, $minifiedPath) {
        (new Minify\CSS($sourcePath))->minify($minifiedPath);
    }
}