<?php

namespace backend\modules\mail_delivery\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use common\classes\Debug;
use common\models\SendMail;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class MailDeliveryController extends Controller
{
    public function actionIndex()
    {
        $file = new MailDelivery();

        if (Yii::$app->request->isPost) {
            $file->excel = UploadedFile::getInstance($file, 'excel');
            $file->parseExcel($file->excel);
        }
        return $this->render('index',
            [
                'file' => $file,
            ]);
    }

    public function actionSend()
    {
        $file = new MailDelivery();
        $users = SendMail::find()->where(['status' => 0])->asArray()->all();
        $file->sendMessage($users);

        return $this->render('index', compact('file'));
    }
}