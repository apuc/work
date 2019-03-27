<?php

namespace frontend\modules\request\controllers;

use common\classes\Debug;
use common\models\Education;
use common\models\Experience;
use common\models\Resume;
use common\models\ResumeSkill;
use common\models\Skill;
use Yii;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class ResumeController extends MyActiveController
{
    public $modelClass = 'common\models\Resume';

    public function actions()
    {

        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionCreate(){
        $model = new Resume();
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        if($model->save()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            if($params['education']){
                foreach($params['education'] as $s_education){
                    $education = new Education();
                    $education->load($s_education, '');
                    $education->resume_id = $model->id;
                    $education->save();
                }
            }
            if($params['work']){
                foreach($params['work'] as $s_experience){
                    $experience = new Experience();
                    $experience->load($s_experience, '');
                    $experience->resume_id = $model->id;
                    $experience->save();
                    //return $experience;
                }
            }
            if($params['skills']){
                ResumeSkill::deleteAll(['resume_id' => $model->id]);
                foreach($params['skills'] as $s_skill){
                    if(!$skill = Skill::find()->where(['name' => $s_skill['name']])->one()){
                        $skill = new Skill();
                        $skill->name = $s_skill['name'];
                        $skill->save();
                    }
                    $resume_skill = new ResumeSkill();
                    $resume_skill->resume_id = $model->id;
                    $resume_skill->skill_id = $skill->id;
                    $resume_skill->save();
                }
            }
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    public function actionTest(){
        return \Yii::$app->user->identity;
    }
}
