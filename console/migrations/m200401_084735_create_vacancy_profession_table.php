<?php

use common\models\Skill;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_profession}}`.
 */
class m200401_084735_create_vacancy_profession_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_profession}}', [
            'profession_id' => $this->integer(),
            'vacancy_id' => $this->integer(),
            'match_type' => $this->tinyInteger()
        ]);
        $this->addPrimaryKey('vacancy_profession_PK','vacancy_profession', ['profession_id', 'vacancy_id']);
        $this->addForeignKey('vacancy_profession_vacancy', 'vacancy_profession', 'vacancy_id', 'vacancy', 'id');
        $this->addForeignKey('vacancy_profession_profession', 'vacancy_profession', 'profession_id', 'professions', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('vacancy_profession_vacancy', 'vacancy_profession');
        $this->dropForeignKey('vacancy_profession_profession', 'vacancy_profession');
        $this->dropTable('{{%vacancy_profession}}');
    }
}
