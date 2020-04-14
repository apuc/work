<?php


namespace console\controllers;


use common\models\Professions;
use common\models\Vacancy;
use common\models\VacancyProfession;
use yii\console\Controller;

class ProfessionController extends Controller
{
    public function actionLink() {
        foreach (\common\models\Professions::find()->where(['status'=>1])->each() as $profession) {
            $condition = ['or'];
            $condition[]=['like', 'post', $profession->title];
            $condition[]=['like', 'responsibilities', $profession->title];
            $condition[]=['like', 'qualification_requirements', $profession->title];
            $condition[]=['like', 'working_conditions', $profession->title];
            $vacancies = \common\models\Vacancy::find()->where($condition)->all();
            foreach ($vacancies as $vacancy) {
                $VP = new VacancyProfession();
                $VP->load(['profession_id' => $profession->id,
                    'vacancy_id' => $vacancy->id,
                    'match_type' => 1], '');
                $VP->save();
            }
            $arr = explode(' ', $profession->title);
            for ($i=0;$i<count($arr);$i++) {
                if(strlen($arr[$i])>3) {
                    $condition[]=['like', 'post', $arr[$i]];
                    $condition[]=['like', 'responsibilities', $arr[$i]];
                    $condition[]=['like', 'qualification_requirements', $arr[$i]];
                    $condition[]=['like', 'working_conditions', $arr[$i]];
                }
                if(strpos($arr[$i], '-') > 0) {
                    $arr[]=explode('-', $arr[$i]);
                    unset($arr[$i]);
                }
            }
            $vacancies = \common\models\Vacancy::find()->where($condition)->all();
            foreach ($vacancies as $vacancy) {
                $vacancy_profession = \common\models\VacancyProfession::find()
                    ->where([
                        'vacancy_id'=>$vacancy->id,
                        'profession_id'=>$profession->id,
                        'match_type'=>1
                    ])
                    ->one();
                if(!$vacancy_profession){
                    $VP = new VacancyProfession();
                    $VP->load(['profession_id' => $profession->id,
                        'vacancy_id' => $vacancy->id,
                        'match_type' => 2], '');
                    $VP->save();
                }
            }
        }
    }
}