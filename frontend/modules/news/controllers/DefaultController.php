<?php

namespace frontend\modules\news\controllers;

use common\classes\Debug;
use common\models\Country;
use common\models\News;
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
            $news = News::find()->where(['country_id' => $model->id])->orderBy('id DESC')->all();
        }else{
        $model = null;
        $news = News::find()->orderBy('id DESC')->all();
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
