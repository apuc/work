<?php

namespace console\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use common\classes\Debug;
use common\models\Message;
use common\models\Resume;
use common\models\SendMail;
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
        $vacancies=Vacancy::find()->where(['notification_status'=>Vacancy::NOTIFICATION_STATUS_OK])->andWhere(['<=', 'update_time', time()-86400*7]);
        /** @var Vacancy $vacancy */
        foreach ($vacancies->each(50) as $vacancy){
            echo $vacancy->post.": 1 неделя\n";
            $vacancy->notification_status=Vacancy::NOTIFICATION_STATUS_1_WEEK;
            $vacancy->save();
            $this->sendNotificationMessage($vacancy, "неделю", Vacancy::className());
        }
        $vacancies=Vacancy::find()->where(['notification_status'=>Vacancy::NOTIFICATION_STATUS_1_WEEK])->andWhere(['<=', 'update_time', time()-86400*14]);
        /** @var Vacancy $vacancy */
        foreach ($vacancies->each(50) as $vacancy){
            echo $vacancy->post.": 2 неделя\n";
            $vacancy->notification_status=Vacancy::NOTIFICATION_STATUS_2_WEEKS;
            $vacancy->save();
            $this->sendNotificationMessage($vacancy, "2 недели", Vacancy::className());
        }
        $resumes=Resume::find()->where(['notification_status'=>Resume::NOTIFICATION_STATUS_OK])->andWhere(['<=', 'update_time', time()-86400*7]);
        /** @var Resume $resume */
        foreach ($resumes->each(50) as $resume){
            echo $resume->title.": 1 неделя\n";
            $resume->notification_status=Resume::NOTIFICATION_STATUS_1_WEEK;
            $resume->save();
            $this->sendNotificationMessage($resume, "неделю", Resume::className());
        }
        $resumes=Resume::find()->where(['notification_status'=>Resume::NOTIFICATION_STATUS_1_WEEK])->andWhere(['<=', 'update_time', time()-86400*14]);
        /** @var Resume $resume */
        foreach ($resumes->each(50) as $resume){
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
        $text='Text';
        switch ($className){
            case Vacancy::className():
                $title=$model->post;
                $text="Ваша вакансия $model->post не обновлялась уже $period";
                break;
            case Resume::className():
                $title=$model->title;
                $text="Ваше резюме $model->title не обновлялось уже $period";
                break;
        }
        $message=new Message();
        $message->load([
            'title'=>$title,
            'text'=>$text
        ], '');
        $message->receiver_id=$model->owner;
        $message->save();
    }
}