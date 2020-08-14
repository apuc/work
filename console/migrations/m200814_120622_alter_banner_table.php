<?php

use yii\db\Migration;

/**
 * Class m200814_120622_alter_banner_table
 */
class m200814_120622_alter_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('banner', 'is_active');
        $this->addColumn('banner', 'active_until', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('banner', 'active_until');
        $this->addColumn('banner', 'is_active', $this->tinyInteger()->defaultValue(0));
    }
}
