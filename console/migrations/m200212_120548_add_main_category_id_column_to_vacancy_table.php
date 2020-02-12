<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy}}`.
 */
class m200212_120548_add_main_category_id_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $empty_category = new \common\models\Category();
        $empty_category->name = 'Пустая категория';
        $this->addColumn('vacancy', 'main_category_id', $this->integer()->notNull()->defaultValue($empty_category->id));
        $this->addForeignKey('vacancy_main_category', 'vacancy', 'main_category_id', 'category', 'id');
        /** @var \common\models\Vacancy $vacancy */
        foreach (\common\models\Vacancy::find()->each() as $vacancy) {
            if($vacancy_category = \common\models\VacancyCategory::find()->where(['vacancy_id'=>$vacancy->id])->one()) {
                $vacancy->main_category_id = $vacancy_category->category_id;
                $vacancy->save();
                $vacancy_category->delete();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('vacancy_main_category', 'vacancy');
        $this->dropColumn('vacancy', 'main_category_id');
    }
}
