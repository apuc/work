<?php

namespace frontend\modules\request\controllers;

use common\models\Company;
use common\models\Vacancy;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class VacancyController extends MyActiveController
{
    public $modelClass = 'common\models\Vacancy';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    /**
     * @return void|\yii\db\ActiveQuery
     */
    public function myQuery(){
        return Vacancy::find()->where(['user_id' => Yii::$app->user->id]);
    }

    /**
     * @throws InvalidConfigException
     * @throws HttpException
     */
    public function actionCreate(){
        $model = new Vacancy();
        $params = Yii::$app->getRequest()->getBodyParams();
        if(Yii::$app->user->isGuest)
            throw new HttpException(400, 'Пользователь не авторизирован');
        $company = Company::findOne(['user_id'=>Yii::$app->user->identity->getId()]);
        if(!$company)
            throw new HttpException(400, 'Вы не являетесь работодателем');
        $model->load($params, '');
        $model->work_experience = Vacancy::getExperienceId($params['work_experience']);
        $model->company_id = $company->id;
        if($model->save()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * @param $id
     * @return Vacancy|null
     * @throws HttpException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate($id){
        $model = Vacancy::findOne($id);
        if(!$model) throw new HttpException(400, 'Такой вакансии не существует');
        $params = Yii::$app->getRequest()->getBodyParams();
        if(Yii::$app->user->isGuest)
            throw new HttpException(400, 'Пользователь не авторизирован');
        $company = Company::findOne(['user_id'=>Yii::$app->user->identity->getId()]);
        if(!$company)
            throw new HttpException(400, 'Вы не являетесь работодателем');
        $model->load($params, '');
        $model->work_experience = Vacancy::getExperienceId($params['work_experience']);
        $model->company_id = $company->id;
        if($model->save()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
