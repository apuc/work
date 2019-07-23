<?php

namespace console\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use common\classes\Debug;
use common\models\SendMail;
use Yii;
use yii\console\Controller;

class SendController extends Controller
{
    public $all;

    public function options($actionID)
    {
        return ['all'];
    }

    public function optionAliases()
    {
        return ['all' => 'all'];
    }

    public function actionIndex()
    {
        $file = new MailDelivery();
        $users = SendMail::find()->where(['status' => 0])->limit(1)->all();
        if($this->all == true) {
            $users = SendMail::find()->where(['status' => 0])->all();
        }
        $file->sendMessage($users);
    }
}