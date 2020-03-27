<?php

namespace frontend\modules\news\controllers;

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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $news = News::find()->all();
        return $this->render('index', [
            'news' => $news
        ]);
    }

    public function actionView($id)
    {
        if(!$model = News::findOne($id))
            throw new NotFoundHttpException();
        return $this->render('view', [
            'model'=>$model
        ]);
    }
}
