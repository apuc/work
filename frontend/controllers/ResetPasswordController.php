<?php


namespace frontend\controllers;


use common\models\User;
use dektrium\user\models\Token;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ResetPasswordController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionSendToken()
    {
        if(!$email = \Yii::$app->request->post('email'))
            return false;
        if(!$user = User::find()->where(['email'=>$email])->one())
            return false;
        /** @var Token $token */
        $token = \Yii::createObject([
            'class' => Token::className(),
            'user_id' => $user->id,
            'type' => Token::TYPE_RECOVERY,
        ]);
        if (!$token->save(false)) {
            return false;
        }
        return true;
    }

    public function actionRecovery()
    {
        $model = new ResetPasswordForm();
        $this->layout = "@frontend/views/layouts/main-layout";
        $model->code = \Yii::$app->request->get('token');
//        if(!$model->code)
//            throw new HttpException(404, 'Not found');
//        /** @var Token $token */
//        if(!$token = Token::find()->where(['code' => $model->code, 'type'=>Token::TYPE_RECOVERY])->one())
//            throw new HttpException(404, 'Not found');
//        if($token->getIsExpired())
//            throw new HttpException(400, 'Срок действия ссылки истёк');

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    public function actionSetPassword()
    {
        $model = new ResetPasswordForm();

    }
}