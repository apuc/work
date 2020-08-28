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
use yii\rest\ActiveController;
use yii\web\HttpException;

class ServicePriceController extends ActiveController
{
    public $modelClass = 'common\models\ServicePrice';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
}
