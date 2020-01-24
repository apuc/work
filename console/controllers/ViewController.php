<?php


namespace console\controllers;


use common\models\Vacancy;
use common\models\Views;
use yii\console\Controller;

class ViewController extends Controller
{

    public function actionVacancyNew()
    {
        $model = Vacancy::getNewVacancy();
        foreach ($model as $item){
            $viewCount = rand(1, 3);
            for ($i=0; $i<$viewCount; $i++){
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_VACANCY;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_VACANCY . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    public function actionVacancyUpdate()
    {
        $model = Vacancy::getNewVacancy();
        foreach ($model as $item){
            $viewCount = rand(1, 3);
            for ($i=0; $i<$viewCount; $i++){
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_VACANCY;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_VACANCY . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

}