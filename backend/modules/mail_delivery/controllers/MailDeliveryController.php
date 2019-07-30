<?php

namespace backend\modules\mail_delivery\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use backend\modules\mail_delivery\models\MailDeliverySearch;
use common\classes\Debug;
use common\models\SendMail;
use dektrium\user\filters\AccessRule;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class MailDeliveryController extends Controller
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
        $file = new MailDeliverySearch();
        $dataProvider = $file->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isPost) {
            $file->excel = UploadedFile::getInstance($file, 'excel');
            if(!empty($file->excel)){
                $file->parseExcel($file->excel);
            }
        }

        return $this->render('index',
            [
                'searchModel' => $file,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionSend($id = null)
    {
        $file = new MailDeliverySearch();
        $dataProvider = $file->search(Yii::$app->request->queryParams);
        $users = SendMail::find()->where(['status' => 0])->all();
        if($id !== null){
            $users = SendMail::find()->where(['id' => $id])->limit(1)->all();
        }
        $file->sendMessage($users);

        return $this->render('index',
            [
                'searchModel' => $file,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionCreate()
    {
        $model = new MailDelivery();
        $arr = [];
        if ($model->load(Yii::$app->request->post())) {
            $arr[] = array_values($model->toArray());
            $model = $model->saveMessage($arr, $model->template);

            return $this->redirect(['view', 'id' => $model]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = SendMail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}