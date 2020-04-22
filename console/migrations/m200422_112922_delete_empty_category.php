<?php

use yii\db\Migration;

/**
 * Class m200422_112922_delete_empty_category
 */
class m200422_112922_delete_empty_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $empty_category_id = \common\models\Category::find()->andWhere(['name'=>'Пустая категория'])->one()->id;
        /** @var \common\models\Vacancy $vacancy */
        foreach (\common\models\Vacancy::find()->each() as $vacancy) {
            if($vacancy->main_category_id === $empty_category_id) {
                if($vacancy->category) {
                    $vacancy->main_category_id = $vacancy->vacancy_category[0]->category_id;
                    $vacancy->save();
                    \common\models\VacancyCategory::deleteAll(['vacancy_id'=>$vacancy->id, 'category_id'=>$vacancy->vacancy_category[0]->category_id]);
                } else {
                    $vacancy->main_category_id = 14;
                    $vacancy->save();
                }
            }
        }
        \common\models\Category::deleteAll(['id'=>$empty_category_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
