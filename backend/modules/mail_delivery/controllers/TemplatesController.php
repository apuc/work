<?php

namespace backend\modules\mail_delivery\controllers;

use backend\modules\mail_delivery\models\MailDeliverySearch;
use common\classes\Debug;
use common\models\SendMail;
use dektrium\user\filters\AccessRule;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class TemplatesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect('/');
                },
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['switch'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $templates = SendMail::getTemplate();
        $file = new MailDeliverySearch();

        if (Yii::$app->request->isPost) {
            $file->letter = UploadedFile::getInstance($file,'letter');
            if(!empty($file->letter)){
                $file->letter->saveAs(\Yii::getAlias('@common/mail/admin_template/' . $file->letter->baseName . '.' . $file->letter->extension));
            }
        }
        $provider = new ArrayDataProvider([
            'allModels' => $templates,
        ]);

        return $this->render('index', compact('provider', 'file'));
    }

    public function actionDelete($id)
    {
        try {
            unlink(\Yii::getAlias('@common/mail/admin_template/' . $id));
        } catch (\ErrorException $exception) {
            echo $exception;
        }

        return $this->redirect(['index']);
    }
}