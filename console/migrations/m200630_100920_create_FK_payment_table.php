<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%FK_payment}}`.
 */
class m200630_100920_create_FK_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%FK_payment}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->decimal(10, 2)->notNull()->comment('Сумма заказа'),
            'operation_number' => $this->integer()->unsigned()->notNull()->comment('Номер операции Free-Kassa'),
            'company_id' => $this->integer()->comment('Компания, на счёт которой зачислены средства'),
            'email' => $this->string()->comment('Email плательщика'),
            'phone' => $this->string()->comment('Телефон плательщика'),
            'currency_id' => $this->integer()->comment('Электронная валюта'),
            'sign' => $this->string()->comment('Подпись')
        ]);
        $this->addForeignKey('payment_company', 'FK_payment', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('payment_company', 'FK_payment');
        $this->dropTable('{{%FK_payment}}');
    }
}
