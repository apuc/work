<?php

namespace frontend\modules\msg\controllers;

use frontend\modules\msg\actions\CGApiAction;
use vision\messages\actions\MessageApiAction;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `msg` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actions()
    {
        return [
            'private-messages' => [
                'class' => MessageApiAction::className()
            ]
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMsg(){

    }
}
