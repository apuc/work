<?php

namespace frontend\modules\request\controllers;


use common\actions\DeleteAction;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\HttpException;

class MyActiveController extends ActiveController
{
    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => function(){
                $query =$this->modelClass::find();
                if(in_array('status', $this->modelClass::attributes())){
                    $query->andWhere([($this->modelClass)::tableName().'.status'=>1]);
                }
                $dataProvider = Yii::createObject([
                    'class' => ActiveDataProvider::className(),
                    'query' => $query,
                    'pagination' => [],
                    'sort' => [],
                ]);

                $expands = explode(',', Yii::$app->request->get('expand'));
                $models = $dataProvider->getModels();
                $response = [];
                /** @var ActiveRecord[] $models */
                foreach ($models as $i=> $model) {
                    $response[$i]=ArrayHelper::toArray($model);
                    if(Yii::$app->request->get('expand')) {
                        foreach ($expands as $expand) {
                            $exploded = explode('.', $expand);
                            if(count($exploded)>1) {
                                $first_item = $exploded[0];
                                $tmp = $model->$first_item;
                                $response[$i][$first_item] = ArrayHelper::toArray($tmp);
                                foreach ($exploded as $j => $item) {
                                    if($j!=0) {
                                        $tmp = $tmp->$item;
                                        $response[$i][$first_item][$item]=is_object($tmp)?ArrayHelper::toArray($tmp):$tmp;
                                    }
                                }

                            } else {
                                $response[$i][$expand]=$model->$expand;
                            }
                        }
                    }
                }
                $pagination = [
                    'current_page'=>$dataProvider->getPagination()->getPage()+1,
                    'page_count'=>$dataProvider->getPagination()->getPageCount(),
                    'per_page'=>$dataProvider->getPagination()->getPageSize(),
                    'total_count'=>$dataProvider->getTotalCount(),
                ];

                return ['pagination'=>$pagination, 'models'=>$response];
            }
        ];
        $actions['delete'] = [
            'class' => 'common\actions\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }
    /**
     * Запрос, показывающий сущности, принадлежащие пользователю
     * @return array
     * @throws HttpException
     * @throws InvalidConfigException
     */
    public function actionMyIndex(){
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        /** @var ActiveQuery $query */
        $query = $this->modelClass::find()->where([($this->modelClass)::tableName().'.owner'=>Yii::$app->user->id]);
        if(in_array('status', $this->modelClass::getTableSchema()->columns)){
            $query->andWhere(['!=',($this->modelClass)::tableName().'.status', 0]);
        }
        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
                'pageSize' => 10
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);

        $expands = explode(',', Yii::$app->request->get('expand'));
        $models = $dataProvider->getModels();
        $response = [];
            /** @var ActiveRecord[] $models */
            foreach ($models as $i=> $model) {
                $response[$i]=ArrayHelper::toArray($model);
                if(Yii::$app->request->get('expand')) {
                    foreach ($expands as $expand) {
                        $exploded = explode('.', $expand);
                        if (count($exploded) > 1) {
                            $first_item = $exploded[0];
                            $tmp = $model->$first_item;
                            if(!isset($response[$i][$first_item]))
                                $response[$i][$first_item] = ArrayHelper::toArray($tmp);
                            foreach ($exploded as $j => $item) {
                                if ($j != 0) {
                                    $tmp = $tmp->$item;
                                    $response[$i][$first_item][$item] = is_object($tmp) ? ArrayHelper::toArray($tmp) : $tmp;
                                }
                            }

                        } else {
                            $response[$i][$expand] = $model->$expand;
                        }
                    }
                }
            }
        $pagination = [
            'current_page'=>$dataProvider->getPagination()->getPage()+1,
            'page_count'=>$dataProvider->getPagination()->getPageCount(),
            'per_page'=>$dataProvider->getPagination()->getPageSize(),
            'total_count'=>$dataProvider->getTotalCount(),
        ];

        return ['pagination'=>$pagination, 'models'=>$response];
    }

    public function beforeAction($action)
    {
        //var_dump($_SERVER);die();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub

        //return true;
    }

    /**
     * Запрос, проверяющий, принадлежит ли сущность текущему пользователю
     */
    public function actionCheckIsMine(){
        if(Yii::$app->user->isGuest)
            return false;
        $id=Yii::$app->request->get('id');
        if(!$model = $this->modelClass::findOne($id)){
            return false;
        }
        if(!$model->hasAttribute('owner'))
            return false;
        if($model->owner == Yii::$app->user->id)
            return true;
        else return false;


    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] =  [
            'class' => Cors::className(),
            'cors'  => [
                // restrict access to domains:
                'Origin'                           => Yii::$app->params['Cors_origin'],
                'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Request-Headers' => ['Origin', 'Content-Type', 'Accept', 'Authorization'],
                'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                'Access-Control-Allow-Origin' => '*'
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    /**
     * @param string $action
     * @param ActiveRecord $model
     * @param array $params
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if($action === 'update' || $action === 'delete'){
            if(Yii::$app->user->isGuest)
                throw new HttpException(403, 'Вы не авторизированы');
            if(!$model->hasAttribute('owner'))
                throw new HttpException(403, 'У вас нет прав для редактирования этой записи');
            if($model->owner != Yii::$app->user->id)
                throw new HttpException(403, 'У вас нет прав для редактирования этой записи');
        }
    }
}
