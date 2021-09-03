<?php

namespace console\controllers;

use common\classes\Debug;
use common\models\Resume;
use common\models\Vacancy;
use common\models\Views;
use yii\console\Controller;

class StatisticController extends Controller
{
    public function actionCountCreatedVacancies($start_date, $end_date)
    {
        /** @var Vacancy[] $vacancies */
        $vacancies = Vacancy::find()
            ->where(['>=', 'created_at', $start_date])
            ->andWhere(['<=', 'created_at', $end_date])
            ->all();
        $cities = [];
        foreach ($vacancies as $vacancy) {
            $cities[] = $vacancy->city0->name;
        }
        $cities = array_count_values($cities);
        foreach ($cities as $key => $city) {
            $this->stdout($key . ' - ' . $city . "\n");
        }
        $this->stdout("\n" . "Итого - " . count($vacancies) . "\n");
    }

    public function actionCountUpdatedVacancies($start_date, $end_date)
    {
        /** @var Vacancy[] $vacancies */
        $vacancies = Vacancy::find()
            ->where(['>=', 'updated_at', $start_date])
            ->andWhere(['<=', 'updated_at', $end_date])
            ->all();
        $cities = [];
        foreach ($vacancies as $vacancy) {
            $cities[] = $vacancy->city0->name;
        }
        $cities = array_count_values($cities);
        foreach ($cities as $key => $city) {
            $this->stdout($key . ' - ' . $city . "\n");
        }
        $this->stdout("\n" . "Итого - " . count($vacancies) . "\n");
    }

    public function actionCountCreatedResumes($start_date, $end_date)
    {
        /** @var Resume[] $resumes */
        $resumes = Resume::find()
            ->where(['>=', 'created_at', $start_date])
            ->andWhere(['<=', 'created_at', $end_date])
            ->all();
        $cities = [];
        foreach ($resumes as $resume) {
            $cities[] = $resume->city0->name;
        }
        $cities = array_count_values($cities);
        foreach ($cities as $key => $city) {
            $this->stdout($key . ' - ' . $city . "\n");
        }
        $this->stdout("\n" . "Итого - " . count($resumes) . "\n");
    }

    public function actionCountUpdatedResumes($start_date, $end_date)
    {
        /** @var Resume[] $resumes */
        $resumes = Resume::find()
            ->where(['>=', 'updated_at', $start_date])
            ->andWhere(['<=', 'updated_at', $end_date])
            ->all();
        $cities = [];
        foreach ($resumes as $resume) {
            $cities[] = $resume->city0->name;
        }
        $cities = array_count_values($cities);
        foreach ($cities as $key => $city) {
            $this->stdout($key . ' - ' . $city . "\n");
        }
        $this->stdout("\n" . "Итого - " . count($resumes) . "\n");
    }

    public function actionResumeViewsByCategories($start_date, $end_date)
    {
        /** @var Views[] $views */
        $views = Views::find()
            ->where(['subject_type' => 'Resume'])
            ->andWhere(['>=', 'dt_view', $start_date])
            ->andWhere(['<=', 'dt_view', $end_date])
            ->andWhere(['indexed' => 1])
            ->all();
        $res = [];
        foreach ($views as $view) {
            if (isset($view->getSubject()->category[0])) {
                $res [] = $view->getSubject()->category[0]->name;
            }
        }
       $res = array_count_values($res);
        foreach ($res as $k => $v) {
            $this->stdout("\n" . $k . " - " . $v . "\n");
        }
    }

    public function actionVacancyViewsByCategories($start_date, $end_date)
    {
        /** @var Views[] $views */
        $views = Views::find()
            ->where(['subject_type' => 'Vacancy'])
            ->andWhere(['>=', 'dt_view', $start_date])
            ->andWhere(['<=', 'dt_view', $end_date])
            ->andWhere(['indexed' => 1])
            ->all();
        $res = [];
        foreach ($views as $view) {
            if (isset($view->subject)) {
                if (isset($view->subject->mainCategory)) {
                    $res [] = $view->subject->mainCategory->name;
                }
            }
        }
        $res = array_count_values($res);
        foreach ($res as $k => $v) {
            $this->stdout("\n" . $k . " - " . $v . "\n");
        }
    }
}