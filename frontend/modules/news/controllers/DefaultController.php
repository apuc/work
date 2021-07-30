<?php

namespace frontend\modules\news\controllers;

use common\models\Country;
use common\models\News;
use common\models\Views;
use Yii;
use yii\base\BaseObject;
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
        if ($slug > null){
            $model = Country::find()->where(['slug' => $slug])->one();
            if (!$model) {
                throw new \yii\web\NotFoundHttpException('404');
            }
            $news = News::find()->where(['country_id' => $model->id])->all();
        }else{
        $model = null;
        $news = News::find()->all();
        }
        if ($model != null){
            $model1 = $model;
            $model = $model->name;
        }else{
            $model1 = $model;
        }
        return $this->render('index', [
            'news' => $news,
            'model' => $model,
            'model1' => $model1
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
             'model'=>$model,
             'random'=>$random,
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
        if($modelCountry){
            return $this->actionIndex($slug);
        }elseif ($modelNews){
            return $this->actionView($slug);
        }else{
            throw new \yii\web\NotFoundHttpException('404');
        }
    }

}
