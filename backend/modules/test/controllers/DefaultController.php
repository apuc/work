<?php

namespace backend\modules\test\controllers;

use apuc\channels_webhook\behaviors\WebHookBehavior;
use yii\web\Controller;

/**
 * Default controller for the `test` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $result = null;
        $post = \Yii::$app->request->post();
        if(isset($post['attributes'])
            && isset($post['url'])
            && isset($post['model_id'])
            && isset($post['url'])
            )
        {
            if($post['attributes']==='')
                $attributes = [];
            else{
                $attributes = str_replace(' ', '', $post['attributes']);
                $attributes = explode(",", $attributes);
            }
            if($post['relations']==='')
                $relations = [];
            else {
                $relations = str_replace(' ', '', $post['relations']);
                $relations = explode(",", $relations);
            }
            $behavior = new WebHookBehavior([
                'url' => $post['url'],
                'attributes' => $attributes,
                'relations' => $relations
            ]);
            $className="common\models\\".$post['class_name'];
            $model = $className::findOne($post['model_id']);
            $behavior->owner = $model;
            $result = $behavior->throwHook();
        }
        return $this->render('index', [
            'request' => $result['attributes'],
            'response' => $result['response'],
            'post' => $post
        ]);
    }
}
