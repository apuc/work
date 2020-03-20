<?php

namespace backend\controllers;

use common\classes\Debug;
use common\models\Resume;
use common\models\Vacancy;
use common\models\Views;
use yii\web\Controller;

class StatisticsController extends Controller
{
    public static $types = [
        1=>'Созданные вакансии',
        2=>'Созданные резюме',
        3=>'Просмотры вакансий',
        4=>'Просмотры резюме'
    ];

    public function actionIndex(){
        if(\Yii::$app->user->isguest) {
            return $this->redirect('/secure/user/login');
        }
        $date1 = \Yii::$app->request->get('date1');
        $date2 = \Yii::$app->request->get('date2')?:'today';
        if(!$date1)
            $datedif = 10;
        else {
            $datedif = (strtotime($date2) - strtotime($date1))/86400+1;
        }
        $dates = ['dates'=>[], 'vacancies'=>[], 'label'=>''];
        $type = \Yii::$app->request->get('type')?:1;
        $view_type = \Yii::$app->request->get('view_type')?:0;
        $total = 0;
        switch ($type) {
            default:
                $dates['label'] = 'Созданные вакансии';
                break;
            case 2:
                $dates['label'] = 'Созданные резюме';
                break;
            case 3:
                $dates['label'] = 'Просмотры вакансий';
                break;
            case 4:
                $dates['label'] = 'Просмотры резюме';
                break;
        }
        for ($i=$datedif-1;$i>=0;$i--) {
            $beginOfDay = strtotime("today", strtotime($date2)-86400*$i);
            $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
            $dates['dates'][] = date('d.m.Y', strtotime($date2)-86400*$i);

            $query = null;
            switch ($type){
                default:
                    $query = Vacancy::find()->where(['>', 'created_at', $beginOfDay])->andWhere(['<', 'created_at', $endOfDay]);
                    break;
                case 2:
                    $query = Resume::find()->where(['>', 'created_at', $beginOfDay])->andWhere(['<', 'created_at', $endOfDay]);
                    break;
                case 3:
                    $query = Views::find()->where(['>', 'dt_view', $beginOfDay])->andWhere(['<', 'dt_view', $endOfDay])->andWhere(['subject_type'=>'Vacancy']);
                    if($view_type == 1)
                        $query->andWhere('viewer_id IS NOT NULL');
                    if($view_type == 2)
                        $query->andWhere('viewer_id IS NULL');
                    break;
                case 4:
                    $query = Views::find()->where(['>', 'dt_view', $beginOfDay])->andWhere(['<', 'dt_view', $endOfDay])->andWhere(['subject_type'=>'Resume']);
                    if($view_type == 1)
                        $query->andWhere('viewer_id IS NOT NULL');
                    if($view_type == 2)
                        $query->andWhere('viewer_id IS NULL');
                    break;
            }
            $count = $query->count();
            $total += $count;
            $dates['data'][] = $count;
        }
        return $this->render('index', [
            'dates' => $dates,
            'type' => $type,
            'total' => $total
        ]);
    }
}