<?php

namespace frontend\modules\request\controllers\api\v1;

class TestController extends ApiParentController
{

    protected function verbs()
    {
        return [
            'test' => ['GET'],
        ];
    }

    public function actionTest()
    {
        return $this->asJson(\Yii::$app->getUser()->getId());
    }
}