<?php

namespace frontend\modules\news\controllers;

use common\classes\Debug;
use common\models\News;
use yii\db\Expression;
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

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $random = News::find()->orderBy('rand()')->one();
        if(!$model = News::findOne($id))
            throw new NotFoundHttpException();
        return $this->render('view', [
            'model'=>$model,
            'random'=>$random,
        ]);
    }
}
