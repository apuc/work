<?php

use yii\db\Migration;

/**
 * Handles adding notification_status to table `{{%resume}}`.
 */
class m190806_084744_add_notification_status_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'notification_status', $this->tinyInteger()->defaultValue(0)->after('views')->comment('Статус для отправления уведомлений'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'notification_status');
    }
}
