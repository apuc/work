<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logo}}`.
 */
class m210827_104736_create_logo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logo}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(11),
            'image' => $this->string(),
            'active_until' => $this->integer(11)
        ]);
        $this->addForeignKey('logo_company', 'logo', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('logo_company', 'logo');
        $this->dropTable('{{%logo}}');
    }
}
