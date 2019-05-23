<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phone`.
 */
class m190410_082749_create_phone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('phone', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'employer_id' => $this->integer(),
            'number' => $this->string()
        ]);
        $this->addForeignKey('phone_employer', 'phone', 'employer_id', 'employer', 'id');
        $this->addForeignKey('phone_company', 'phone', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('phone_employer', 'phone');
        $this->dropForeignKey('phone_company', 'phone');
        $this->dropTable('phone');
    }
}
