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
    public $id;

    public function options($actionID)
    {
        return ['all', 'id'];
    }

    public function optionAliases()
    {
        return [
            'all' => 'all',
            'id' => 'id',
            ];
    }

    public function actionIndex()
    {
        $file = new MailDelivery();
        $users = SendMail::find()->where(['id' => $this->id])->limit(1)->all();
        if($this->all == true) {
            $users = SendMail::find()->where(['status' => 0])->all();
        }
        $file->sendMessage($users, true);
    }
}