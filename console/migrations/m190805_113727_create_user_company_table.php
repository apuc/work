<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_company}}`.
 */
class m190805_113727_create_user_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_company}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'company_id' => $this->integer()
        ]);
        $this->addForeignKey('user_company_company', 'user_company', 'user_id', 'user', 'id');
        $this->addForeignKey('user_company_user', 'user_company', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_company_company', 'user_company');
        $this->dropForeignKey('user_company_user', 'user_company');
        $this->dropTable('{{%user_company}}');
    }
}
