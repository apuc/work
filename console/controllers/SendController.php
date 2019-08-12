<?php

namespace console\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use common\classes\Debug;
use common\models\Message;
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

    public function actionNotification()
    {
        $vacancies=Vacancy::find()->where(['notification_status'=>Vacancy::NOTIFICATION_STATUS_OK])->andWhere(['<=', 'update_time', time()-86400*7]);
        /** @var Vacancy $vacancy */
        foreach ($vacancies->each(50) as $vacancy){
            echo $vacancy->post.": 1 неделя\n";
            $vacancy->notification_status=Vacancy::NOTIFICATION_STATUS_1_WEEK;
            $vacancy->save();
            $this->sendNotificationMessageVacancy($vacancy, "неделю");
        }
        $vacancies=Vacancy::find()->where(['notification_status'=>Vacancy::NOTIFICATION_STATUS_1_WEEK])->andWhere(['<=', 'update_time', time()-86400*14]);
        /** @var Vacancy $vacancy */
        foreach ($vacancies->each(50) as $vacancy){
            echo $vacancy->post.": 2 неделя\n";
            $vacancy->notification_status=Vacancy::NOTIFICATION_STATUS_2_WEEKS;
            $vacancy->save();
            $this->sendNotificationMessageVacancy($vacancy, "2 недели");
        }
    }

    /**
     * @param Vacancy $vacancy
     */
    public function sendNotificationMessageVacancy($vacancy, $text)
    {
        $message=new Message();
        $message->load([
            'title'=>$vacancy->post,
            'text'=>"Ваша вакансия $vacancy->post не обновлялась уже $text"
        ], '');
        $message->receiver_id=$vacancy->owner;
        $message->save();
    }
}