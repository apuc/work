<?php

namespace frontend\modules\request\controllers;

use common\models\LoginForm;
use common\models\User;
use dektrium\user\helpers\Password;
use frontend\modules\request\models\PasswordRestore;
use Yii;
use yii\rest\Controller;
use yii\web\HttpException;

class SecurityController extends Controller
{
    public function actionChangePassword()
    {
        $params = Yii::$app->request->post();
        if (Yii::$app->user->isGuest)
            throw new HttpException(500, 'Ошибка');
        $password_restore = new PasswordRestore();
        if ($password_restore->load($params, '') && $password_restore->validate()) {
            if (Password::validate($password_restore->old_password, Yii::$app->user->identity->password_hash)) {
                Yii::$app->user->identity->password_hash = Password::hash($password_restore->new_password_1);
                Yii::$app->user->identity->save();
                return true;
            } else {
                throw new HttpException(403, 'Неверный пароль');
            }
        } else {
            return $password_restore->errors;
        }
    }
}
