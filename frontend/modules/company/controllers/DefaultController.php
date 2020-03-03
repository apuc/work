<?php

namespace frontend\modules\company\controllers;

use common\models\Company;
use common\models\Message;
use common\models\Resume;
use common\models\User;
use common\models\Views;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;


class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Company::find()->where(['id'=>$id, 'status'=>Company::STATUS_ACTIVE])->andWhere(['!=', 'name', ''])->andWhere(['!=', 'name', 'null'])->one();
        if(!$model)
            throw new NotFoundHttpException();
        $view = new Views();
        $view->subject_type = 'Company';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionSendMessage()
    {
        $post = Yii::$app->request->post();
        $resume = Resume::findOne($post['company_resume_id']);
        $company = Company::findOne($post['company_company_id']);
        if ($resume && $company) {
            $message = new Message();
            $message->text = $post['company_message'];
            $message->sender_id = Yii::$app->user->id;
            $message->subject = 'Company';
            $message->subject_id = $company->id;
            $message->receiver_id = $company->owner;
            $message->subject_from = 'Resume';
            $message->subject_from_id = $resume->id;
            $message->save();
            Yii::$app->mailer->compose('company_like',
                ['resume' => $resume, 'company' => $company, 'text' => $message->text])
                ->setFrom('noreply@rabota.today')
                ->setTo(User::findOne($company->owner)->email)
                ->setSubject('Кто-то хочет работать в вашей компании "'.$company->name.'"')
                ->send();
        } else throw new HttpException('400', 'Ошибка');
        $url = explode('?', Yii::$app->request->referrer)[0];
        $url .= '?message=Ваше сообщение успешно отправлено';
        return $this->redirect($url);
    }
}
