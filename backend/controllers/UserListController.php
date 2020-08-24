<?php


namespace backend\controllers;


use dektrium\user\controllers\AdminController;
use dektrium\user\models\UserSearch;
use yii\helpers\Url;

class UserListController extends AdminController
{
    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $searchModel  = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
}