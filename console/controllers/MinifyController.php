<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;
use MatthiasMullie\Minify;

class MinifyController extends Controller
{
    public function actionIndex() {
        $this->minifyJS(Yii::getAlias("@frontend/web/js/script.js"), Yii::getAlias("@frontend/web/js/script.min.js"));
        $this->minifyJS(Yii::getAlias("@frontend/web/js/resizeSensor.js"), Yii::getAlias("@frontend/web/js/resizeSensor.min.js"));
        $this->minifyJS(Yii::getAlias("@frontend/web/js/resume_search.js"), Yii::getAlias("@frontend/web/js/resume_search.min.js"));
        $this->minifyJS(Yii::getAlias("@frontend/web/js/vacancy_search.js"), Yii::getAlias("@frontend/web/js/vacancy_search.min.js"));
        $this->minifyJS(Yii::getAlias("@frontend/web/js/jquery.sticky-kit.js"), Yii::getAlias("@frontend/web/js/jquery.sticky-kit.min.js"));

        $this->minifyCSS(Yii::getAlias("@frontend/web/css/main_style.css"), Yii::getAlias("@frontend/web/css/main_style.min.css"));
        $this->minifyCSS(Yii::getAlias("@frontend/web/css/back-styles.css"), Yii::getAlias("@frontend/web/css/back-styles.min.css"));
        $this->minifyCSS(Yii::getAlias("@frontend/web/css/style.css"), Yii::getAlias("@frontend/web/css/style.min.css"));
        $this->minifyCSS(Yii::getAlias("@frontend/web/js/slick/slick.css"), Yii::getAlias("@frontend/web/js/slick/slick.min.css"));
    }
    public function minifyJS($sourcePath, $minifiedPath) {
        (new Minify\JS($sourcePath))->minify($minifiedPath);
    }
    public function minifyCSS($sourcePath, $minifiedPath) {
        (new Minify\CSS($sourcePath))->minify($minifiedPath);
    }
}