<?php

namespace backend\modules\news\controllers;

use common\models\TagsRelation;
use common\classes\Debug;
use common\models\Tags;
use dektrium\user\filters\AccessRule;
use Yii;
use common\models\News;
use backend\modules\news\models\NewsSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect('/');
                },
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['switch'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_create = $model->dt_update = strtotime(date("Y-m-d H:i:s"));
            if (empty($model->dt_public)) {
                $model->dt_public = null;
            } else {
                $model->dt_public = strtotime($model->dt_public);
            }
            $model->save();
            if (!empty(Yii::$app->request->post('Tags'))) {
                foreach (Yii::$app->request->post('Tags') as $tag) {
                    $tags = new TagsRelation();
                    $tags->news_id = $model->id;
                    $tags->tags_id = $tag;
                    $tags->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $tags = Tags::find()->asArray()->all();

        return $this->render('create', [
            'model' => $model,
            'tags' => $tags,
            'tags_selected' => [],
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->dt_update = strtotime(date("Y-m-d H:i:s"));
            $model->dt_create = strtotime($model->dt_create);
            if (empty($model->dt_public)) {
                $model->dt_public = null;
            } else {
                $model->dt_public = strtotime($model->dt_public);
            }
            $model->save();
            if (!empty(Yii::$app->request->post('Tags'))) {
                TagsRelation::deleteAll(['news_id' => $id]);
                foreach (Yii::$app->request->post('Tags') as $tag) {
                    $tags = new TagsRelation();
                    $tags->news_id = $model->id;
                    $tags->tags_id = $tag;
                    $tags->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $tags = Tags::find()->asArray()->all();
        $tags_selected = ArrayHelper::getColumn(TagsRelation::find()->select('tags_id')
            ->where(['news_id' => $id])
            ->asArray()
            ->all(), 'tags_id');

        return $this->render('update', [
            'model' => $model,
            'tags' => $tags,
            'tags_selected' => $tags_selected,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
