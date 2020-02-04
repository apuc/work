<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meta_data".
 *
 * @property int $id
 * @property int $category_id
 * @property string $vacancy_meta_title
 * @property string $vacancy_meta_description
 * @property string $vacancy_header
 * @property string $vacancy_meta_title_with_city
 * @property string $vacancy_meta_description_with_city
 * @property string $vacancy_header_with_city
 * @property string $vacancy_bottom_text
 * @property string $resume_meta_title
 * @property string $resume_meta_description
 * @property string $resume_header
 * @property string $resume_meta_title_with_city
 * @property string $resume_meta_description_with_city
 * @property string $resume_header_with_city
 * @property string $resume_bottom_text
 *
 * @property Category $category
 */
class MetaData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['vacancy_meta_description', 'vacancy_meta_description_with_city', 'vacancy_bottom_text', 'resume_meta_description', 'resume_meta_description_with_city', 'resume_bottom_text'], 'string'],
            [['vacancy_meta_title', 'vacancy_header', 'vacancy_meta_title_with_city', 'vacancy_header_with_city', 'resume_meta_title', 'resume_header', 'resume_meta_title_with_city', 'resume_header_with_city'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'vacancy_meta_title' => 'Vacancy Meta Title',
            'vacancy_meta_description' => 'Vacancy Meta Description',
            'vacancy_header' => 'Vacancy Header',
            'vacancy_meta_title_with_city' => 'Vacancy Meta Title With City',
            'vacancy_meta_description_with_city' => 'Vacancy Meta Description With City',
            'vacancy_header_with_city' => 'Vacancy Header With City',
            'vacancy_bottom_text' => 'Vacancy Bottom Text',
            'resume_meta_title' => 'Resume Meta Title',
            'resume_meta_description' => 'Resume Meta Description',
            'resume_header' => 'Resume Header',
            'resume_meta_title_with_city' => 'Resume Meta Title With City',
            'resume_meta_description_with_city' => 'Resume Meta Description With City',
            'resume_header_with_city' => 'Resume Header With City',
            'resume_bottom_text' => 'Resume Bottom Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}