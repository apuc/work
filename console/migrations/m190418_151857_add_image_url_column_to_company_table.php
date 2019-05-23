<?php

use yii\db\Migration;

/**
 * Handles adding image_url to table `company`.
 */
class m190418_151857_add_image_url_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'image_url', $this->string()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'image_url');
    }
}
