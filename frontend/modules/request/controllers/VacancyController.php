<?php

namespace frontend\modules\request\controllers;

use common\models\Company;
use common\models\Vacancy;
use Yii;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class VacancyController extends MyActiveController
{
    public $modelClass = 'common\models\Vacancy';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * @throws \yii\base\InvalidConfigException
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
