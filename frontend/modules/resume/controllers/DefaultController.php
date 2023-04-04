<?php

namespace frontend\modules\resume\controllers;

use common\classes\Debug;
use common\models\Action;
use common\models\Category;
use common\models\City;
use common\models\EmploymentType;
use common\models\Message;
use common\models\Resume;
use common\models\Skill;
use common\models\User;
use common\models\Vacancy;
use common\models\Views;
use frontend\modules\resume\classes\ResumeSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UrlManager;

/**
 * Default controller for the `resume` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public $background_image;
    public $background_emblem;

    public function actionView($id)
    {
        $model = Resume::find()->where(['id'=>$id, 'status'=>[Resume::STATUS_ACTIVE, Resume::STATUS_HIDDEN]])->one();
        if(!$model)
            throw new NotFoundHttpException();
        $referer_category = false;
        if(Yii::$app->request->get('referer_category'))
            $referer_category = Category::findOne(Yii::$app->request->get('referer_category'));
        $view = new Views();
        $view->subject_type = 'Resume';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
        return $this->render('view', [
            'model' => $model,
            'referer_category' => $referer_category
        ]);
    }

    public function actionSendMessage(){
        $post = Yii::$app->request->post();
        /** @var Resume $resume */
        $resume = Resume::findOne($post['resume_resume_id']);
        $vacancy = Vacancy::find()
            ->where(['id' => $post['resume_vacancy_id']])
            ->andWhere(['>', Vacancy::tableName().'.active_until', time()])
            ->one();
        if($resume && $vacancy ){
            $message = new Message();
            $message->text = $post['resume_message'];
            $message->sender_id = Yii::$app->user->id;
            $message->subject = 'Resume';
            $message->subject_id = $resume->id;
            $message->receiver_id = $resume->owner;
            $message->subject_from = 'Vacancy';
            $message->subject_from_id = $post['resume_vacancy_id'];
            $message->save();
            Yii::$app->mailer->compose('resume_like', ['resume'=>$resume, 'vacancy'=>$vacancy, 'text'=>$message->text])
                ->setFrom(Yii::$app->params['senderEmail'])
                ->setTo(User::findOne($resume->owner)->email)
                ->setSubject('Ответ на ваше резюме '. $resume->title.'.')
                ->send();
        }
        $url = explode('?', Yii::$app->request->referrer)[0];
        $url.='?message=Ваше сообщение успешно отправлено';
        return $this->redirect($url);
    }

    public function actionSearch()
    {
        $searchModel = new ResumeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $canonical_rel = Yii::$app->request->hostInfo.'/resume'.($searchModel->first_query_param?('/'.$searchModel->first_query_param):'').($searchModel->second_query_param?('/'.$searchModel->second_query_param):'');
        if($searchModel->current_city) {
                $this->background_image = $searchModel->current_city->image;
            }
        if($searchModel->current_category) {
                $this->background_emblem = $searchModel->current_category->image;
                $params['category_ids']=[$searchModel->current_category->id];
            }
        $tags = Skill::find()->all();
        $categories = Category::find()->all();
        $employment_types = EmploymentType::find()->all();
        $cities = City::find()->where(['status' => 1])->orderBy('priority ASC')->all();

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags' => $tags,
            'cities' => $cities,
            'categories' => $categories,
            'employment_types' => $employment_types,
            'city' => $searchModel->current_city,
            'current_category' => $searchModel->current_category,
            'canonical_rel' => $canonical_rel,
        ]);
    }

    public function actionClickPhone() {
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if(!$id = Yii::$app->request->post('id')) {
                throw new HttpException(404, 'Not Found');
            } else if (Resume::findOne(intval($id))){
                if($action = Action::find()->where(['type'=>'click_phone', 'subject'=>'resume', 'subject_id'=>$id])->one()) {
                    $action->count++;
                    $action->save();
                } else {
                    $action = new Action();
                    $action->type = 'click_phone';
                    $action->subject = 'resume';
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
