<?php

namespace console\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use common\classes\Debug;
use common\models\Message;
use common\models\Resume;
use common\models\SendMail;
use common\models\User;
use common\models\Vacancy;
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

    public function actionDeploy() {
        $result = shell_exec("../../deploy.sh");
        if($result)
            print_r($result);
        else
            echo "Ошибка";
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

    public function actionNotifications()
    {
        $vacancies=Vacancy::find()
            ->where(['notification_status'=>Vacancy::NOTIFICATION_STATUS_OK])
            ->andWhere(['<=', 'update_time', time()-86400*7])
            ->andWhere(['!=', 'status', Vacancy::STATUS_INACTIVE])
            ->limit(5)
            ->all();
        /** @var Vacancy[] $vacancies */
        foreach ($vacancies as $vacancy){
            echo $vacancy->post.": 1 неделя\n";
            $vacancy->notification_status=Vacancy::NOTIFICATION_STATUS_1_WEEK;
            $vacancy->save();
            $this->sendNotificationMessage($vacancy, "неделю", Vacancy::className());
        }
        $vacancies=Vacancy::find()
            ->where(['notification_status'=>Vacancy::NOTIFICATION_STATUS_1_WEEK])
            ->andWhere(['<=', 'update_time', time()-86400*14])
            ->andWhere(['!=', 'status', Vacancy::STATUS_INACTIVE])
            ->limit(5)
            ->all();
        /** @var Vacancy $vacancy */
        foreach ($vacancies as $vacancy){
            echo $vacancy->post.": 2 неделя\n";
            $vacancy->notification_status=Vacancy::NOTIFICATION_STATUS_2_WEEKS;
            $vacancy->save();
            $this->sendNotificationMessage($vacancy, "2 недели", Vacancy::className());
        }
        $resumes=Resume::find()
            ->where(['notification_status'=>Resume::NOTIFICATION_STATUS_OK])
            ->andWhere(['<=', 'update_time', time()-86400*7])
            ->andWhere(['!=', 'status', Resume::STATUS_INACTIVE])
            ->limit(5)
            ->all();
        /** @var Resume $resume */
        foreach ($resumes as $resume){
            echo $resume->title.": 1 неделя\n";
            $resume->notification_status=Resume::NOTIFICATION_STATUS_1_WEEK;
            $resume->save();
            $this->sendNotificationMessage($resume, "неделю", Resume::className());
        }
        $resumes=Resume::find()
            ->where(['notification_status'=>Resume::NOTIFICATION_STATUS_1_WEEK])
            ->andWhere(['<=', 'update_time', time()-86400*14])
            ->andWhere(['!=', 'status', Resume::STATUS_INACTIVE])
            ->limit(5)
            ->all();
        /** @var Resume $resume */
        foreach ($resumes as $resume){
            echo $resume->title.": 2 неделя\n";
            $resume->notification_status=Resume::NOTIFICATION_STATUS_2_WEEKS;
            $resume->save();
            $this->sendNotificationMessage($resume, "2 недели", Resume::className());
        }
    }

    /**
     * @param Vacancy $vacancy
     * @param string $text
     */
    public function sendNotificationMessage($model, $period, $className)
    {
        $title='Title';
        $template = '';
        $text = '';
        switch ($className){
            case Vacancy::className():
                $title=$model->post;
                $text="Ваша вакансия $model->post не обновлялась уже $period";
                $template = "notification_vacancy";
                break;
            case Resume::className():
                $title=$model->title;
                $text="Ваше резюме $model->title не обновлялось уже $period";
                $template = "notification_resume";
                break;
        }
        Yii::$app->mailer->compose($template, ['model'=>$model])
            ->setFrom('noreply@rabota.today')
            ->setTo(User::findOne($model->owner)->email)
            ->setSubject($title)
            ->send();
        $message=new Message();
        $message->load([
            'title'=>$title,
            'text'=>$text
        ], '');
        $message->receiver_id=$model->owner;
        $message->save();
    }
}