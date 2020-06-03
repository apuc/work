<?php


namespace frontend\controllers;


use common\classes\Debug;
use common\models\Employer;
use dektrium\user\models\LoginForm;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\Token;
use dektrium\user\models\User;
use dektrium\user\Module;
use frontend\models\user\RegUserForm;
use Yii;
use yii\base\ViewContextInterface;
use yii\web\NotFoundHttpException;

class RegistrationController extends \dektrium\user\controllers\RegistrationController implements ViewContextInterface
{
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRegister()
    {
        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegUserForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);
        $post = \Yii::$app->request->post();
        $post['register-form']['username'] = $post['register-form']['email'];
        if ($model->load($post) && $model->register()) {
            $this->trigger(self::EVENT_AFTER_REGISTER, $event);
            /** @var User $user */
            $user = User::find()->where(['email' => $post['register-form']['email']])->one();
            $employer = new Employer();
            $employer->first_name = $post['first_name'];
            $employer->second_name = $post['second_name'];
            $employer->user_id = $user->id;
            $employer->owner = $user->id;
            $employer->save();
            $token = Token::findOne(['user_id'=>$user->id]);
            Yii::$app->mailer->viewPath='@common/mail';
            Yii::$app->mailer->compose('registration_notification', ['employer'=>$employer, 'user'=>$user, 'token'=>$token])
                ->setFrom('noreply@rabota.today')
                ->setTo($user->email)
                ->setSubject('Спасибо за регистрацию')
                ->send();
        }
        $url = explode('?', Yii::$app->request->referrer)[0];
        $url.='?message=Ваш аккаунт успешно зарегистрирован, проверьте почту для получения дальнейших инструкций';
        return $this->redirect($url);
    }
    /**
     * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message.
     *
     * @param int    $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);
        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
        $user->attemptConfirmation($code);
        $this->afterConfirm($event);
        return $this->redirect('/?message=Ваш аккаунт был успешно активирован');
    }

    public function afterConfirm($event)
    {
        //\common\classes\Debug::dd(123);
        $cookie = Yii::createObject([
            'class' => 'yii\web\Cookie',
            'name' => 'key',
            'value' => Yii::$app->user->identity->getAuthKey(),
            'expire' => time() + 7*86400,
            'httpOnly' => false
        ]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    public function actionSendToken()
    {
        echo 123; die;
    }
}