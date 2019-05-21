<?php

namespace frontend\modules\personal_area\controllers;

use common\classes\Debug;
use common\models\Company;
use common\models\Message;
use common\models\Resume;
use common\models\Vacancy;
use yii\web\Controller;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if(!\Yii::$app->user->isGuest)
            return $this->renderFile('@frontend/web/vue/dist/index.html');
        return $this->redirect('/');
    }

    /**
     * @throws HttpException
     */
    public function actionStatistics(){
        if(\Yii::$app->user->isGuest)
            throw new HttpException(404, 'Not found');
        $result = ['Vacancy'=>[], 'Resume'=>[], 'Company'=>[]];
        /** @var Vacancy[] $vacancies */
        $vacancies = Vacancy::find()->where(['owner'=>\Yii::$app->user->id, 'status'=>Vacancy::STATUS_ACTIVE])->all();
        foreach ($vacancies as $vacancy){
            $responses = Message::find()->where(['subject'=>'Vacancy', 'subject_id'=>$vacancy->id])->count();
            $result['Vacancy'][]=[
                'name' => $vacancy->post,
                'views' => $vacancy->views,
                'responses' => $responses
            ];
        }
        /** @var Resume[] $resumes */
        $resumes = Resume::find()->where(['owner'=>\Yii::$app->user->id, 'status'=>Resume::STATUS_ACTIVE])->all();
        foreach ($resumes as $resume){
            $responses = Message::find()->where(['subject'=>'Resume', 'subject_id'=>$resume->id])->count();
            $result['Resume'][]=[
                'name' => $resume->title,
                'views' => $resume->views,
                'responses' => $responses
            ];
        }
        return json_encode($result);
    }
}
