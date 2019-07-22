<?php
/**
 * Created by PhpStorm.
 * User: Офис
 * Date: 05.05.2016
 * Time: 10:52
 */

namespace frontend\models\user;


use common\classes\Debug;
use dektrium\user\models\Token;
use dektrium\user\models\User;
use Yii;

class ResendForm extends \dektrium\user\models\ResendForm
{
    /**
     * Creates new confirmation token and sends it to the user.
     *
     * @return bool
     */
    public function resend()
    {
        if (!$this->validate()) {
            return false;
        }
//        Debug::prn($_POST);
        $request = Yii::$app->request->post();
//Debug::prn($request ['resend-form']['email']);
        $user_id = User::find()->where(['email' => $request['resend-form']['email']])->one();
        /** @var Token $token */
        $token = Yii::createObject([
            'class'   => Token::className(),
            'user_id' => $user_id->id,
            'type'    => Token::TYPE_CONFIRMATION,
        ]);
        $token->save(false);
        $this->mailer->sendConfirmationMessage($user_id, $token);


        return true;
    }
}