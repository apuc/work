<?php

namespace frontend\modules\request\controllers;

use common\classes\Debug;
use common\models\Message;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\HttpException;

class MessageController extends MyActiveController
{
    public $modelClass = 'common\models\Message';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        return $behaviors;
    }

    public function prepareDataProvider()
    {
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $query=Message::find();
        if(isset($requestParams['type'])){
            if($requestParams['type']==='incoming'){
                $query->andWhere(['receiver_id'=>Yii::$app->user->id, 'deleted_by_receiver'=>0]);
            } else if($requestParams['type']==='outgoing'){
                $query->andWhere(['sender_id'=>Yii::$app->user->id, 'deleted_by_sender'=>0]);
            }
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
        //Debug::dd($dataProvider);

        $expands = explode(',', Yii::$app->request->get('expand'));
        $models = $dataProvider->getModels();
        $response = array();
        /** @var ActiveRecord[] $models */
        foreach ($models as $i=> $model) {
            if ($model->sender_id != null && (!$model->subject0 || !$model->subject0_from)) continue;
            $response[$i]=ArrayHelper::toArray($model);
            foreach ($expands as $expand) {
                $exploded = explode('.', $expand);
                if(count($exploded)>1) {
                    $first_item = $exploded[0];
                    $tmp = $model->$first_item;
                    if($tmp) {
                        $response[$i][$first_item] = ArrayHelper::toArray($tmp);
                        foreach ($exploded as $j => $item) {
                            if($j!=0) {
                                $tmp = $tmp->$item;
                                $response[$i][$first_item][$item]=is_object($tmp)?ArrayHelper::toArray($tmp):$tmp;
                                Debug::prn(123);
                            }
                        }
                    }

                } else {
                    $response[$i][$expand]=$model->$expand;
                }
            }
        }
        $pagination = [
            'current_page'=>$dataProvider->getPagination()->getPage()+1,
            'page_count'=>$dataProvider->getPagination()->getPageCount(),
            'per_page'=>$dataProvider->getPagination()->getPageSize(),
            'total_count'=>$dataProvider->getTotalCount(),
        ];

        return ['pagination'=>$pagination, 'models'=>(array)$response, 'wwkdbc' => "hhhhhh"];
    }
    /**
     * @param string $action
     * @param Message $model
     * @param array $params
     * @throws HttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if($action != 'index'){
            if(Yii::$app->user->isGuest)
                throw new HttpException(403, 'Вы не авторизированы');
            if($model->receiver_id != Yii::$app->user->id && $model->sender_id != Yii::$app->user->id)
                throw new HttpException(403, 'Отказано в доступе');
        }
    }

    public function actionReadAllMessages(){
        if(!Yii::$app->request->isPost)
            throw new HttpException(404, 'Not found');
        if(Yii::$app->user->isGuest)
            throw new HttpException(403, 'Вы не авторизированы');
        $messages=Message::find()->where(['receiver_id'=>Yii::$app->user->id])->all();
        foreach ($messages as $message){
            $message->is_read=1;
            $message->save();
        }
        return 1;
    }

    public function actionDeleteMessage(){
        if(!Yii::$app->request->isPost)
            throw new HttpException(404, 'Not found');
        if(Yii::$app->user->isGuest)
            throw new HttpException(403, 'Вы не авторизированы');
        $type = Yii::$app->request->post('type');
        if($type=='incoming'){
            $message=Message::find()->where(['id'=>Yii::$app->request->post('id'), 'receiver_id'=>Yii::$app->user->id])->one();
            $message->deleted_by_receiver=1;
            $message->save();
        }
        if($type=='outgoing'){
            $message=Message::find()->where(['id'=>Yii::$app->request->post('id'), 'sender_id'=>Yii::$app->user->id])->one();
            $message->deleted_by_sender=1;
            $message->save();
        }
        return 1;
    }
}
