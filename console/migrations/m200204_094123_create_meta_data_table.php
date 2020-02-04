<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meta_data}}`.
 */
class m200204_094123_create_meta_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meta_data}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'vacancy_meta_title' => $this->string(),
            'vacancy_meta_description' => $this->text(),
            'vacancy_header' => $this->string(),
            'vacancy_meta_title_with_city' => $this->string(),
            'vacancy_meta_description_with_city' => $this->text(),
            'vacancy_header_with_city' => $this->string(),
            'vacancy_bottom_text' => $this->text(),
            'resume_meta_title' => $this->string(),
            'resume_meta_description' => $this->text(),
            'resume_header' => $this->string(),
            'resume_meta_title_with_city' => $this->string(),
            'resume_meta_description_with_city' => $this->text(),
            'resume_header_with_city' => $this->string(),
            'resume_bottom_text' => $this->text(),
        ]);
        $this->addForeignKey('category_meta_data', 'meta_data', 'category_id', 'category', 'id');
        $categories = (new \yii\db\Query)->from('category')->all();
        foreach ($categories as $category) {
            $this->insert('meta_data', [
                'category_id' => $category['id'],
                'vacancy_meta_title' => $category['meta_title'],
                'vacancy_meta_description' => $category['meta_description'],
                'vacancy_header' => $category['header'],
                'vacancy_meta_title_with_city' => $category['meta_title_with_city'],
                'vacancy_meta_description_with_city' => $category['meta_description_with_city'],
                'vacancy_header_with_city' => $category['header_with_city'],
                'vacancy_bottom_text' => $category['bottom_text'],
                'resume_meta_title' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['meta_title'])),
                'resume_meta_description' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['meta_description'])),
                'resume_header' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['header'])),
                'resume_meta_title_with_city' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['meta_title_with_city'])),
                'resume_meta_description_with_city' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['meta_description_with_city'])),
                'resume_header_with_city' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['header_with_city'])),
                'resume_bottom_text' => str_replace(['вакансия', 'вакансии', 'вакансию'], 'резюме', str_replace(['Вакансия', 'Вакансии', 'Вакансию'], 'Резюме', $category['bottom_text'])),
            ]);
        }
        $this->dropColumn('category', 'meta_title');
        $this->dropColumn('category', 'meta_description');
        $this->dropColumn('category', 'header');
        $this->dropColumn('category', 'meta_title_with_city');
        $this->dropColumn('category', 'meta_description_with_city');
        $this->dropColumn('category', 'header_with_city');
        $this->dropColumn('category', 'bottom_text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //$this->dropTable('{{%meta_data}}');
    }
}
