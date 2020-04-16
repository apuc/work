<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geobase_country}}`.
 */
class m200415_081507_create_geobase_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%geobase_country}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'slug' => $this->string()->notNull()->comment('Название латинскими буквами'),
            'meta_title' => $this->string()->comment('Заголовок главной старницы'),
            'meta_description' => $this->text()->comment('Описание главной страницы'),
            'meta_header' => $this->string()->comment('h1 заголовок главной страницы'),
            'main_page_text' => $this->text()->comment('Текст на главной странице'),
            'main_page_background_image' => $this->string()->comment('Фоновое изображение главной страницы'),
            'main_page_emblem' => $this->string()->comment('Эмблема главной страницы'),

        ]);
        $this->addColumn('geobase_region', 'country_id', $this->integer());
        $this->addForeignKey('geobase_region_geobase_country', 'geobase_region', 'country_id', 'geobase_country', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('geobase_region_geobase_country', 'geobase_region');
        $this->dropColumn('geobase_region', 'country_id');
        $this->dropTable('{{%geobase_country}}');
    }
}
