<?php

namespace frontend\modules\company\controllers;

use common\models\Action;
use common\models\City;
use common\models\Company;
use common\models\Message;
use common\models\Resume;
use common\models\User;
use common\models\Vacancy;
use common\models\Views;
use Yii;
use yii\helpers\ArrayHelper;
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
        $last_vacancies = Vacancy::find()
            ->where(['status'=>Vacancy::STATUS_ACTIVE])
            ->andWhere(['>', Vacancy::tableName().'.active_until', time()])
            ->limit(2)
            ->orderBy('update_time DESC')
            ->all();
        $view = new Views();
        $view->subject_type = 'Company';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
        $cities = City::find()
            ->select(['geobase_city.id', 'geobase_city.name', 'geobase_city.slug'])
            ->innerJoin('vacancy', 'vacancy.city_id = geobase_city.id')
            ->where([
                'vacancy.status' => 1,
                'vacancy.company_id' => $id
            ])
            ->groupBy('geobase_city.id')
            ->orderBy('count(geobase_city.id) DESC')
            ->limit(3)
            ->all();
        return $this->render('view', [
            'model' => $model,
            'cities' => $cities,
            'last_vacancies' => $last_vacancies
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
                ->setFrom(Yii::$app->params['senderEmail'])
                ->setTo(User::findOne($company->owner)->email)
                ->setSubject('Кто-то хочет работать в вашей компании "'.$company->name.'"')
                ->send();
        } else throw new HttpException('400', 'Ошибка');
        $url = explode('?', Yii::$app->request->referrer)[0];
        $url .= '?message=Ваше сообщение успешно отправлено';
        return $this->redirect($url);
    }

    public function actionClickPhone() {
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if(!$id = Yii::$app->request->post('id')) {
                throw new HttpException(404, 'Not Found');
            } else if (Company::findOne(intval($id))){
                if($action = Action::find()->where(['type'=>'click_phone', 'subject'=>'company', 'subject_id'=>$id])->one()) {
                    $action->count++;
                    $action->save();
                } else {
                    $action = new Action();
                    $action->type = 'click_phone';
                    $action->subject = 'company';
                    $action->subject_id = $id;
                    $action->count = 1;
                    $action->save();
                }
            } else {
                throw new HttpException(404, 'Not Found');
            }
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }
}
