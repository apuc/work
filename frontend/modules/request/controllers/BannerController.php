<?php

namespace frontend\modules\request\controllers;


use common\classes\FileHandler;
use common\models\Banner;
use Yii;
use yii\base\UserException;
use yii\web\HttpException;

class BannerController extends MyActiveController
{
    public $modelClass = 'common\models\Banner';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index']);
    }

    public function actionCreate()
    {
        if(Yii::$app->user->isGuest)
            throw new HttpException(400, 'Пользователь не авторизирован');
        if(Yii::$app->user->identity->status < 20)
            throw new HttpException(400, 'Создание баннеров доступно только работодателям');
        $model = new Banner();
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        $model->is_active = 0;
        $model->company_id = Yii::$app->user->identity->company->id;
        if($params['image']) {
            $model->image_url = FileHandler::saveFileFromBase64($params['image'], 'company_custom');
        }
        if($params['logo']) {
            $model->logo_url = FileHandler::saveFileFromBase64($params['logo'], 'company_custom');
        }
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new UserException('Ошибка при создании баннера.');
        }

        return $model;
    }

    public function actionUpdate($id){
        $model = Banner::findOne($id);
        if(!$model)
            throw new HttpException(400, 'Такого баннера не существует');

        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        $model->company_id = Yii::$app->user->identity->company->id;
        if($params['image']){
            unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->image_url");
            $model->image_url = FileHandler::saveFileFromBase64($params['image'], 'company_custom');
        } else {
            if($model->image_url) {
                unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->image_url");
            }
            $model->image_url = null;
        }
        if($params['logo']){
            unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->logo_url");
            $model->logo_url = FileHandler::saveFileFromBase64($params['image'], 'company_custom');
        } else {
            if($model->logo_url) {
                unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->logo_url");
            }
            $model->logo_url = null;
        }
        if($model->save()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new UserException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * @param string $action
     * @param Banner $model
     * @param array $params
     * @throws HttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if($action === 'update' || $action === 'delete'){
            if(Yii::$app->user->isGuest)
                throw new UserException('Вы не авторизированы', 403);
            if(!$model->canAccess(Yii::$app->user->id))
                throw new UserException('У вас нет прав для редактирования этой записи', 403);
        }
    }
}
