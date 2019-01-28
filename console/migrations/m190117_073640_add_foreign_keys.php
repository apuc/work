<?php

use yii\db\Migration;

/**
 * Class m190117_073640_add_foreign_keys
 */
class m190117_073640_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('employer_user', 'employer', 'user_id', 'security', 'id');
        $this->addForeignKey('company_user', 'company', 'user_id', 'security', 'id');
        $this->addForeignKey('resume_employer', 'resume', 'employer_id', 'employer', 'id');
        $this->addForeignKey('resume_employment_type', 'resume', 'employment_type_id', 'employment_type', 'id');
        $this->addForeignKey('resume_schedule', 'resume', 'schedule_id', 'schedule', 'id');
        $this->addForeignKey('vacancy_company', 'vacancy', 'company_id', 'company', 'id');
        $this->addForeignKey('vacancy_employment_type', 'vacancy', 'employment_type_id', 'employment_type', 'id');
        $this->addForeignKey('vacancy_schedule', 'vacancy', 'schedule_id', 'schedule', 'id');
        $this->addForeignKey('resume_skill_resume', 'resume_skill', 'resume_id', 'resume', 'id');
        $this->addForeignKey('resume_skill_skill', 'resume_skill', 'skill_id', 'skill', 'id');
        $this->addForeignKey('vacancy_skill_vacancy', 'vacancy_skill', 'vacancy_id', 'vacancy', 'id');
        $this->addForeignKey('vacancy_skill_skill', 'vacancy_skill', 'skill_id', 'skill', 'id');
        $this->addForeignKey('experience_resume', 'experience', 'resume_id', 'resume', 'id');
        $this->addForeignKey('education_resume', 'education', 'resume_id', 'resume', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('company_user', 'company');
        $this->dropForeignKey('employer_user', 'employer');
        $this->dropForeignKey('resume_employer', 'resume');
        $this->dropForeignKey('resume_employment_type', 'resume');
        $this->dropForeignKey('resume_schedule', 'resume');
        $this->dropForeignKey('vacancy_company', 'vacancy');
        $this->dropForeignKey('vacancy_employment_type', 'vacancy');
        $this->dropForeignKey('vacancy_schedule', 'vacancy');
        $this->dropForeignKey('resume_skill_resume', 'resume_skill');
        $this->dropForeignKey('resume_skill_skill', 'resume_skill');
        $this->dropForeignKey('vacancy_skill_vacancy', 'vacancy_skill');
        $this->dropForeignKey('vacancy_skill_skill', 'vacancy_skill');
        $this->dropForeignKey('experience_resume', 'experience');
        $this->dropForeignKey('education_resume', 'education');
    }

}
