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

        $news = News::find()
            ->where(['<', 'dt_public', time()])
            ->orderBy(['dt_public' => SORT_DESC])
            ->limit(20)
            ->all();
        $feed = new \kavalar\Feed;

        $feed->addChannel('https://rabota.today/news-rss');

// required channel elements
        $feed
            ->addChannelTitle('Новостная лента портала Rabota.Today')
            ->addChannelLink(Url::toRoute('/', true))
            ->addChannelDescription('Rabota.Today – интернет-портал для поиска работы. В новостном разделе регулярно публикуется поучительный контент о персонале, начальстве, деньгах, собеседованиях, нюансах трудовых будней и тематические развлекательные статьи. Следи за обновлениями – держи руку на пульсе HR-сферы!');

// optional channel elements
        $feed
            ->addChannelLanguage(Yii::$app->language);

        foreach ($news as $new) {
            $feed->addItem();
            $feed->addItemAttribute('turbo', 'true');
// title or description are required
            $feed
                ->addItemTitle($new->title)
                ->addItemDescription($new->description);

            $feed
                ->addItemLink(Url::toRoute(['/news/'.$new->slug],true), true)
                ->addItemGuid(Url::toRoute(['/news/'.$new->slug],true), true)
                ->addItemPubDate($new->dt_public); // timestamp/strtotime/DateTime
        }

        echo $feed;
    }

}
