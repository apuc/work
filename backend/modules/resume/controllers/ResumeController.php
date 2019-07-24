<?php

namespace backend\modules\resume\controllers;

use common\classes\Debug;
use common\models\ResumeCategory;
use common\models\ResumeEmploymentType;
use common\models\ResumeSkill;
use dektrium\user\filters\AccessRule;
use Yii;
use common\models\Resume;
use backend\modules\resume\models\ResumeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ResumeController implements the CRUD actions for Resume model.
 */
class ResumeController extends Controller
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
     * Lists all Resume models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResumeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Resume model.
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
     * Creates a new Resume model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Resume();
        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($post['Resume']['category']){
                foreach ($post['Resume']['category'] as $category){
                    $resume_category = new ResumeCategory();
                    $resume_category->resume_id = $model->id;
                    $resume_category->category_id = $category;
                    $resume_category->save();
                }
            }
            if($post['Resume']['skills']){
                foreach ($post['Resume']['skills'] as $skill){
                    $resume_skill = new ResumeSkill();
                    $resume_skill->resume_id = $model->id;
                    $resume_skill->skill_id = $skill;
                    $resume_skill->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Resume model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $model = $this->findModel($id);

        if ($model->load($post) && $model->save()) {
            if($post['Resume']['category']){
                foreach($model->resume_category as $category){
                    $category->delete();
                }
                foreach ($post['Resume']['category'] as $category){
                    $resume_category = new ResumeCategory();
                    $resume_category->resume_id = $model->id;
                    $resume_category->category_id = $category;
                    $resume_category->save();
                }
            }
            if($post['Resume']['skills']){
                foreach($model->resume_skill as $skill){
                    $skill->delete();
                }
                foreach ($post['Resume']['skills'] as $skill){
                    $resume_skill = new ResumeSkill();
                    $resume_skill->resume_id = $model->id;
                    $resume_skill->skill_id = $skill;
                    $resume_skill->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Resume model.
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
     * Finds the Resume model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resume the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resume::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
