<?php

use yii\db\Migration;

/**
 * Class m200824_131026_alter_vacancy_table
 */
class m200824_131026_alter_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'active_until', $this->integer());
        $this->addColumn('vacancy', 'day_vacancy_until', $this->integer()->defaultValue(0));
        $this->dropColumn('vacancy', 'is_day_vacancy');
        $this->update('vacancy', [
            'active_until' => time() + (86400 * 30)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'active_until');
        $this->dropColumn('vacancy', 'day_vacancy_until');
        $this->addColumn('vacancy', 'is_day_vacancy', $this->tinyInteger());
    }
}
