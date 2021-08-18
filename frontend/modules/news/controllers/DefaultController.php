<?php

namespace frontend\modules\news\controllers;

use common\classes\Debug;
use common\models\Country;
use common\models\News;
use common\models\Views;
use DateTime;
use Yii;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `news` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    /**
     * @param null $slug
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionIndex($slug = null)
    {
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $news = News::find();
        $pagination = new Pagination([
            'totalCount' => $news->count(),
            'pageSize' => 10,
            'defaultPageSize' => 10,
            'pageSizeParam' => false,
            'page' => $page - 1,
        ]);
        if ($slug > null) {
            $model = Country::find()->where(['slug' => $slug])->one();
            if (!$model) {
                throw new \yii\web\NotFoundHttpException('404');
            }
            $news = $news->where(['country_id' => $model->id])->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->all();
        } else {
            $model = null;
            $news = $news->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->all();
        }
        if ($model != null) {
            $model1 = $model;
            $model = $model->name;
        } else {
            $model1 = $model;
        }

        return $this->render('index', [
            'news' => $news,
            'model' => $model,
            'model1' => $model1,
            'pagination' => $pagination
        ]);
    }

    /**
     * @param null $slug
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionView($slug = null)
    {
        $model = News::find()->where(['slug' => $slug])->one();
        $random = News::find()
            ->orderBy('rand()')
            ->where(['<>', 'id', $model->id])
            ->one();
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('404');
        }
        $view = new Views();
        $view->subject_type = 'New';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
        return $this->render('view', [
            'model' => $model,
            'random' => $random,
        ]);
    }

    /**
     * @param null $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSearch($slug = null)
    {
        $modelCountry = Country::find()->where(['slug' => $slug])->one();
        $modelNews = News::find()->where(['slug' => $slug])->one();
        if ($modelCountry) {
            return $this->actionIndex($slug);
        } elseif ($modelNews) {
            return $this->actionView($slug);
        } else {
            throw new \yii\web\NotFoundHttpException('404');
        }
    }

    public function actionRss()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => News::find()
                ->where(['<', 'dt_public', time()])
                ->orderBy(['dt_public' => SORT_DESC])->limit(20),

        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        $response->content = \Zelenin\yii\extensions\Rss\RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => 'Новостная лента портала Rabota.Today',
                'link' => Url::toRoute('/', true),
                'description' => 'Rabota.Today – интернет-портал для поиска работы. В новостном разделе регулярно публикуется поучительный контент о персонале, начальстве, деньгах, собеседованиях, нюансах трудовых будней и тематические развлекательные статьи. Следи за обновлениями – держи руку на пульсе HR-сферы!',
                'language' => Yii::$app->language
            ],
            'items' => [
                'title' => function ($model, $widget) {
                    return $model->title;
                },
                'description' => function ($model, $widget) {
                    return StringHelper::truncateWords($model->description, 50);
                },
                'link' => function ($model, $widget) {
                    return Url::toRoute(['/news/'.$model->slug], true);
                },
                'pubDate' => function ($model, $widget) {
                    $date = DateTime::createFromFormat('d-m-Y', $model->dt_public);

                    return $date->format(DATE_RSS);
                },
            ]
        ]);
    }

}
