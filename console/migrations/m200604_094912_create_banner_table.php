<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 */
class m200604_094912_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('banner', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(11)->notNull(),
            'description' => $this->string(125),
            'image_url' => $this->string(255),
            'logo_url' => $this->string(255),
            'is_active' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'priority' => $this->integer(11),
            'owner' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);

        $this->addFkBannerCompany();
        $this->addFkBannerOwner();

    }


    /**
     * Add references to company_id
     */
    private function addFkBannerCompany()
    {
        $this->addForeignKey(
            'banner_company',
            'banner',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );
    }


    /**
     * Add references to owner
     */
    private function addFkBannerOwner()
    {
        $this->addForeignKey(
            'banner_owner',
            'banner',
            'owner',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('banner');
    }
}
