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
    public $limit;

    public function options($actionID)
    {
        return ['all', 'id', 'limit'];
    }

    public function optionAliases()
    {
        return [
            'all' => 'all',
            'id' => 'id',
            'limit' => 'limit',
            ];
    }

    public function actionIndex()
    {
        $file = new MailDelivery();
        $users = SendMail::find()->where(['id' => $this->id])->limit(1)->orderBy('id DESC')->all();
        if($this->all == true) {
            $users = SendMail::find()->where(['status' => 0])->limit($this->limit)->orderBy('id DESC')->all();
        }
        $file->sendMessage($users, true);
    }
}