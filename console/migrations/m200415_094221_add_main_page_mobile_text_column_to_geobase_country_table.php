<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%geobase_country}}`.
 */
class m200415_094221_add_main_page_mobile_text_column_to_geobase_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_country', 'main_page_mobile_text', $this->text()
            ->after('main_page_text')
            ->comment('Текст на главной странице для мобильных устройств')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_country', 'main_page_mobile_text');
    }
}
