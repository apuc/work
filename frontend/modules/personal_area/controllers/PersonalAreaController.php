<?php

namespace frontend\modules\personal_area\controllers;

class PersonalAreaController extends \yii\web\Controller
{
    public $layout = '@frontend/views/layouts/personal-area.php';
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCharts()
    {
        return $this->render('chartjs');
    }
    public function actionForms()
    {
        return $this->render('basic-forms');
    }
    public function actionButtons()
    {
        return $this->render('buttons');
    }
    public function actionTables()
    {
        return $this->render('tables');
    }
    public function actionTypography()
    {
        return $this->render('typography');
    }

}
