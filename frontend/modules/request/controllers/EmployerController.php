<?php

namespace frontend\modules\request\controllers;

use common\models\Company;
use common\models\Employer;
use common\models\Message;
use common\models\Phone;
use common\models\Resume;
use common\models\Vacancy;
use dektrium\user\models\User;
use Yii;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class EmployerController extends MyActiveController
{
    public $modelClass = 'common\models\Employer';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionMyIndex(){
        return Employer::find()->where(['user_id'=>Yii::$app->user->id])->one();
    }

    /**
     * @param $id
     * @return Employer
     * @throws HttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id){
        $model = Employer::findOne($id);
        if(!$model) throw new UserException('Ошибка изменения профиля: профиль отсутствует');
        $this->checkAccess($this->action->id, $model);
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        if($model->save()){
            Phone::deleteAll(['employer_id' => $model->id]);
            if($params['phone']){
                $phone = new Phone();
                $phone->employer_id = $model->id;
                $phone->number = $params['phone'];
                $phone->save();
            }
            $user = User::findOne(Yii::$app->user->id);
            $user->email=$params['email'];
            $user->username=$params['email'];
            $user->save();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new UserException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * @throws HttpException
     */
    public function actionStatistics(){
        if(\Yii::$app->user->isGuest)
        throw new HttpException(404, 'Not found');
        $result = ['Vacancy'=>[], 'Resume'=>[]];
        /** @var Vacancy[] $vacancies */
        $vacancies = Vacancy::find()->where(['owner'=>\Yii::$app->user->id, 'status'=>Vacancy::STATUS_ACTIVE])->all();
        foreach ($vacancies as $vacancy){
            $responses = Message::find()->where(['subject'=>'Vacancy', 'subject_id'=>$vacancy->id])->count();
            $result['Vacancy'][]=[
                'id' => $vacancy->id,
                'name' => $vacancy->post,
                'views' => $vacancy->views,
                'responses' => $responses,
                'click_phone_count' => $vacancy->clickPhoneCount
            ];
        }
        /** @var Resume[] $resumes */
        $resumes = Resume::find()->where(['owner'=>\Yii::$app->user->id])->andWhere(['!=', 'status', Resume::STATUS_INACTIVE])->all();
        foreach ($resumes as $resume){
            $responses = Message::find()->where(['subject'=>'Resume', 'subject_id'=>$resume->id])->count();
            $result['Resume'][]=[
                'id' => $resume->id,
                'name' => $resume->title,
                'views' => $resume->countViews,
                'responses' => $responses,
                'click_phone_count' => $resume->clickPhoneCount
            ];
        }
        /** @var Company[] $companies */
        $companies = Company::find()->where(['owner'=>\Yii::$app->user->id, 'status'=>Company::STATUS_ACTIVE])->andWhere(['!=', 'name', ''])->all();
        foreach ($companies as $company){
            $responses = Message::find()->where(['subject'=>'Company', 'subject_id'=>$company->id])->count();
            $result['Company'][]=[
                'id' => $company->id,
                'name' => $company->name?$company->name:($company->user->employer->first_name.' '.$company->user->employer->second_name),
                'views' => $company->countViews,
                'responses' => $responses,
                'click_phone_count' => $company->clickPhoneCount
            ];
        }
        return $result;
    }

    public function actionGetPaymentHash() {
        $amount = Yii::$app->request->get('amount');
        $company = Company::find()->where(['user_id' => Yii::$app->user->id])->one();
        if(!$company)
            throw new UserException('У вас нет прав на совершение этого действия');
        return md5('214123'.':'.$amount.':'.'m648uqdn'.':'.$company->id);
    }

}
