<?php

namespace frontend\modules\request\controllers;

use common\models\Employer;
use common\models\Phone;
use Yii;
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

    /**
     * @param $id
     * @return Employer
     * @throws HttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id){
        $model = Employer::findOne($id);
        if(!$model) throw new HttpException(400, 'Ошибка изменения профиля: профиль отсутствует');
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
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
