<?php

namespace frontend\modules\request\controllers\api\v1;

use AccessTokenAuth;
use yii\rest\Controller;

/**
 * Родительский класс для наследования от него Api-контроллеров
 *
 * @author Alex Korona
 */
abstract class ApiParentController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => AccessTokenAuth::class,
        ];

        return $behaviors;
    }
}