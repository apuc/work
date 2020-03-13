<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy}}`.
 */
class m200313_090017_add_publisher_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'publisher_id', $this->integer()->comment('Пользователь, разместивший вакансию'));
        /** @var \common\models\Vacancy $vacancy */
        foreach (\common\models\Vacancy::find()->each() as $vacancy) {
            $vacancy->publisher_id = $vacancy->owner;
            $vacancy->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'publisher_id');
    }
}
