<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mk_payment}}`.
 */
class m230413_152604_create_mk_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mk_payment}}', [
            'id' => $this->primaryKey(),
            'transaction_id' => $this->string(),
            'payment' => $this->integer(),
            'merchant' => $this->integer(),
            'amount' => $this->float(),
            'sign' => $this->string(),
            'email' => $this->string(),
            'date' => $this->integer(),
            'company_id' => $this->integer()
        ]);
        $this->addForeignKey('company_id', 'mk_payment', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('company_id', 'mk_payment');
        $this->dropTable('{{%mk_payment}}');
    }
}
