<?php

use yii\db\Migration;

/**
 * Handles adding notification_status to table `{{%vacancy}}`.
 */
class m190806_085154_add_notification_status_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'notification_status', $this->tinyInteger()->defaultValue(0)->after('views')->comment('Статус для отправления уведомлений'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'notification_status');
    }
}
