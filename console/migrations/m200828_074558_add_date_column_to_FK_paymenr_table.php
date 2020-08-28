<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%FK_paymenr}}`.
 */
class m200828_074558_add_date_column_to_FK_paymenr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('FK_payment', 'date', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('FK_payment', 'date');
    }
}
