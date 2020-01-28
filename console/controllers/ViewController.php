<?php


namespace console\controllers;


use common\models\Resume;
use common\models\Vacancy;
use common\models\Views;
use yii\console\Controller;

class ViewController extends Controller
{

    /**
     * Просмотр новых вакансий
     */
    public function actionVacancyNew()
    {
        $model = Vacancy::getNewVacancy();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_VACANCY;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_VACANCY . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    /**
     * Просмотр обновленных вакансий
     */
    public function actionVacancyUpdate()
    {
        $model = Vacancy::getUpdateVacancy();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_VACANCY;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_VACANCY . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    /**
     * Просмотр новых резюме
     */
    public function actionResumeNew()
    {
        //echo time() . "\n";
        $model = Resume::getNewResume();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_RESUME;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_RESUME . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    /**
     * просмотр обновленных резюме
     */
    public function actionResumeUpdate()
    {
        $model = Resume::getUpdateResume();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_RESUME;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_RESUME . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

}