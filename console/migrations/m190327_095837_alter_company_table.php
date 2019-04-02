<?php

use yii\db\Migration;

/**
 * Class m190327_095837_alter_company_table
 */
class m190327_095837_alter_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('company', 'title');
        $this->addColumn('company', 'name', $this->string()->after('user_id')->comment('Название'));
        $this->addColumn('company', 'website', $this->string()->after('name')->comment('Сайт'));
        $this->addColumn('company', 'activity_field', $this->text()->after('website')->comment('Сфера деятельности'));
        $this->addColumn('company', 'vk', $this->string()->after('activity_field'));
        $this->addColumn('company', 'facebook', $this->string()->after('vk'));
        $this->addColumn('company', 'instagram', $this->string()->after('facebook'));
        $this->addColumn('company', 'skype', $this->string()->after('instagram'));
        $this->addColumn('company', 'description', $this->text()->after('skype')->comment('О компании'));
        $this->addColumn('company', 'contact_person', $this->string()->after('description')->comment('Контактное лицо'));
        $this->addColumn('company', 'phone', $this->string()->after('contact_person')->comment('Телефон'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('company', 'title', $this->string());
        $this->dropColumn('company', 'name');
        $this->dropColumn('company', 'website');
        $this->dropColumn('company', 'activity_field');
        $this->dropColumn('company', 'vk');
        $this->dropColumn('company', 'facebook');
        $this->dropColumn('company', 'instagram');
        $this->dropColumn('company', 'skype');
        $this->dropColumn('company', 'description');
        $this->dropColumn('company', 'contact_person');
        $this->dropColumn('company', 'phone');
    }

}
