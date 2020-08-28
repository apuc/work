<?php

namespace frontend\modules\request\controllers;

use common\models\Promocode;
use Yii;
use yii\base\UserException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class PromocodeController extends Controller
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [];
    }

    /**
     * @throws UserException
     */
    public function actionUse() {
        $promocode = Promocode::findOne(['code' => Yii::$app->request->getBodyParam('promocode')]);
        if (!$promocode) {
            throw new UserException('Неверный промокод');
        }
        $promocode->activate();
    }

    public $modelClass = 'common\models\Action';
}
