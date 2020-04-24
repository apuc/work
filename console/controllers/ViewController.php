<?php


namespace console\controllers;


use common\models\Resume;
use common\models\Vacancy;
use common\models\Views;
use Yii;
use yii\console\Controller;
use yii\db\Query;

class ViewController extends Controller
{
    public function actionIndexVacancies() {
        $views = (new Query())->from(Views::tableName())->select(['subject_id', 'count(subject_id)'])->where(['subject_type'=>'Vacancy', 'indexed'=>0])->groupBy('subject_id')->all();
        foreach ($views as $view) {
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("update vacancy set views=views+".$view['count(subject_id)']." where id=1138")->query();
            echo "ID: ".$view['subject_id'] . "---> +" . $view['count(subject_id)']."\n";
            Views::updateAll(['indexed'=>1], ['subject_type'=>'Vacancy', 'subject_id'=>$view['subject_id'], 'indexed'=>0]);
        }
    }


    /**
     * Просмотр новых вакансий
     */
    public function actionVacancyNew()
    {
        $model = Vacancy::getNewVacancy();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_VACANCY;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_VACANCY . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    /**
     * Просмотр обновленных вакансий
     */
    public function actionVacancyUpdate()
    {
        $model = Vacancy::getUpdateVacancy();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_VACANCY;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_VACANCY . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    /**
     * Просмотр новых резюме
     */
    public function actionResumeNew()
    {
        //echo time() . "\n";
        $model = Resume::getNewResume();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_RESUME;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_RESUME . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

    /**
     * просмотр обновленных резюме
     */
    public function actionResumeUpdate()
    {
        $model = Resume::getUpdateResume();
        foreach ($model as $item) {
            $viewCount = rand(1, 3);
            for ($i = 0; $i < $viewCount; $i++) {
                $view = new Views();
                $view->subject_id = $item->id;
                $view->subject_type = Views::TYPE_RESUME;
                $view->dt_view = time();
                $view->save();
            }
            echo Views::TYPE_RESUME . " id: " . $item->id . ", views: " . $viewCount . "\n";
        }
    }

}