<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meta_data".
 *
 * @property int $id
 * @property int $category_id
 * @property int $profession_id
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
 * @property Professions $profession
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
            [['category_id', 'profession_id'], 'integer'],
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
            'profession_id' => 'Профессия',
            'vacancy_meta_title' => 'Заголовок вакансий',
            'vacancy_meta_description' => 'Описание вакансий',
            'vacancy_header' => 'h1 заголовок вакансий',
            'vacancy_meta_title_with_city' => 'Заголовок вакансий с городом',
            'vacancy_meta_description_with_city' => 'Описание вакансий с городом',
            'vacancy_header_with_city' => 'h1 заголовок вакансий с городом',
            'vacancy_bottom_text' => 'Текст снизу вакансий',
            'resume_meta_title' => 'Заголовок резюме',
            'resume_meta_description' => 'Описание резюме',
            'resume_header' => 'h1 заголовок резюме',
            'resume_meta_title_with_city' => 'Заголовок резюме с городом',
            'resume_meta_description_with_city' => 'Описание резюме с городом',
            'resume_header_with_city' => 'h1 заголовок резюме с городом',
            'resume_bottom_text' => 'Текст снизу резюме',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfession()
    {
        return $this->hasOne(Professions::className(), ['id' => 'profession_id']);
    }
}