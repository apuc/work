<?php

use yii\db\Migration;

/**
 * Class m190425_131929_add_owner_column
 */
class m190425_131929_add_owner_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'owner', $this->integer());
        $this->addColumn('education', 'owner', $this->integer());
        $this->addColumn('employer', 'owner', $this->integer());
        $this->addColumn('experience', 'owner', $this->integer());
        $this->addColumn('phone', 'owner', $this->integer());
        $this->addColumn('resume', 'owner', $this->integer());
        $this->addColumn('resume_category', 'owner', $this->integer());
        $this->addColumn('resume_skill', 'owner', $this->integer());
        $this->addColumn('vacancy', 'owner', $this->integer());
        $this->addColumn('vacancy_category', 'owner', $this->integer());
        $this->addColumn('vacancy_skill', 'owner', $this->integer());

        $this->addForeignKey('company_owner', 'company', 'owner', 'user', 'id');
        $this->addForeignKey('education_owner', 'education', 'owner', 'user', 'id');
        $this->addForeignKey('employer_owner', 'employer', 'owner', 'user', 'id');
        $this->addForeignKey('experience_owner', 'experience', 'owner', 'user', 'id');
        $this->addForeignKey('phone_owner', 'phone', 'owner', 'user', 'id');
        $this->addForeignKey('resume_owner', 'resume', 'owner', 'user', 'id');
        $this->addForeignKey('resume_category_owner', 'resume_category', 'owner', 'user', 'id');
        $this->addForeignKey('resume_skill_owner', 'resume_skill', 'owner', 'user', 'id');
        $this->addForeignKey('vacancy_owner', 'vacancy', 'owner', 'user', 'id');
        $this->addForeignKey('vacancy_category_owner', 'vacancy_category', 'owner', 'user', 'id');
        $this->addForeignKey('vacancy_skill_owner', 'vacancy_skill', 'owner', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'owner');
        $this->dropColumn('education', 'owner');
        $this->dropColumn('employer', 'owner');
        $this->dropColumn('experience', 'owner');
        $this->dropColumn('phone', 'owner');
        $this->dropColumn('resume', 'owner');
        $this->dropColumn('resume_category', 'owner');
        $this->dropColumn('resume_skill', 'owner');
        $this->dropColumn('vacancy', 'owner');
        $this->dropColumn('vacancy_category', 'owner');
        $this->dropColumn('vacancy_skill', 'owner');

        $this->dropForeignKey('company_owner', 'company');
        $this->dropForeignKey('education_owner', 'education');
        $this->dropForeignKey('employer_owner', 'employer');
        $this->dropForeignKey('experience_owner', 'experience');
        $this->dropForeignKey('phone_owner', 'phone');
        $this->dropForeignKey('resume_owner', 'resume');
        $this->dropForeignKey('resume_category_owner', 'resume_category');
        $this->dropForeignKey('resume_skill_owner', 'resume_skill');
        $this->dropForeignKey('vacancy_owner', 'vacancy');
        $this->dropForeignKey('vacancy_category_owner', 'vacancy_category');
        $this->dropForeignKey('vacancy_skill_owner', 'vacancy_skill');
    }

}