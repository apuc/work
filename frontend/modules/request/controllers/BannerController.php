<?php

namespace frontend\modules\request\controllers;


use common\classes\FileHandler;
use common\models\Banner;
use common\models\BannerLocation;
use common\models\Category;
use common\models\City;
use common\models\Company;
use Yii;
use yii\base\UserException;
use yii\web\HttpException;

class BannerController extends MyActiveController
{
    public $modelClass = 'common\models\Banner';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['index']);
        return $actions;
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
        if(!isset($params['city_category']) || !is_array($params['city_category']))
            throw new UserException('Добавьте связь');
        foreach ($params['city_category'] as $city_category) {
            $bannerLocation = new BannerLocation();
            $bannerLocation->banner_id = $model->id;
            if (City::findOne($city_category['city_id'])) {
                $bannerLocation->city_id = $city_category['city_id'];
            } else {
                throw new UserException("Такого города нет.");
            }
            if (Category::findOne($city_category['category_id']))
                $bannerLocation->category_id = $city_category['category_id'];
            $bannerLocation->save();
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
            $url = FileHandler::saveFileFromBase64($params['image'], 'company_custom');
            if($params['image'] !== $url)
                $model->image_url = $url;
        } else {
            if($model->image_url) {
                unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->image_url");
            }
            $model->image_url = null;
        }
        if($params['logo']){
            $url = FileHandler::saveFileFromBase64($params['logo'], 'company_custom');
            if($params['logo'] !== $url)
                $model->logo_url = $url;
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

        if(!isset($params['city_category']))
            throw new UserException('Добавьте связь');
        BannerLocation::deleteAll(['banner_id'=>$model->id]);
        foreach ($params['city_category'] as $city_category) {
            $bannerLocation = new BannerLocation();
            $bannerLocation->banner_id = $model->id;
            if (City::findOne($city_category['city_id'])) {
                $bannerLocation->city_id = $city_category['city_id'];
            } else {
                throw new UserException("Такого города нет.");
            }
            if (Category::findOne($city_category['category_id']))
                $bannerLocation->category_id = $city_category['category_id'];
            $bannerLocation->save();
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

    public function actionActivate() {
        if (!Yii::$app->request->post('banner_id') || !$banner = Banner::findOne(Yii::$app->request->post('banner_id'))) {
            throw new UserException('Такого баннера не существует');
        }
        /** @var Company $company */
        $company = Yii::$app->user->identity->company;
        if (!$company) {
            throw new UserException('У вас не прав для совершения этого действия');
        }
        $price = 0;
        foreach ($banner->bannerLocations as $bannerLocation) {
            if ($bannerLocation->city_id) {
                $price += 500;
            } else {
                throw new UserException("Такого города нет.");
            }
            if ($bannerLocation->category_id)
                $price -= 250;
        }
        if ($company->balance < $price) {
            throw new UserException('У вас недостаточно средств на счету');
        }
        $company->balance -= $price;
        $company->save();
        if (!$banner->active_until || $banner->active_until < time())
            $banner->active_until = time() + (86400*30);
        else
            $banner->active_until += 86400*30;
        $banner->save();
        return true;
    }

    public function actionGetPrice() {
        $params = json_decode(Yii::$app->request->getQueryParam('city_category'), true);
//        print_r($params[0]); die;
        if(!isset($params))
            throw new UserException('Добавьте связь');
        $price = 0;
        foreach ($params as $city_category) {
            if (City::findOne($city_category['city_id'])) {
                $price += 500;
            } else {
                throw new UserException("Такого города нет.");
            }
            if (Category::findOne($city_category['category_id']))
                $price -= 250;
        }
        return $price;
    }
}
