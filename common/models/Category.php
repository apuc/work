<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_description
 * @property string $header
 * @property string $meta_title_with_city
 * @property string $meta_description_with_city
 * @property string $header_with_city
 * @property string $bottom_text
 *
 * @property int $vacancy_count
 * @property ResumeCategory[] $resumeCategories
 */
class Category extends WorkActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function beforeSave($insert)
    {
        if($insert)
            $this->slug = \common\classes\LocoTranslitFilter::cyrillicToLatin($this->name, 100, true);
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image', 'meta_title', 'header', 'meta_title_with_city', 'header_with_city', 'bottom_text'], 'string', 'max' => 255],
            [['meta_description', 'meta_description_with_city'], 'string'],
            [['name'], 'required']
        ];
    }

    public function extraFields()
    {
        return ['resume', 'resumeCategories'];
    }

    public function getRelateDeleteList()
    {
        return ['vacancyCategories', 'resumeCategories'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'image' => 'Фотография',
            'slug' => 'Slug',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'header' => 'h1 заголовок',
            'meta_title_with_city' => 'Meta title с городом',
            'meta_description_with_city' => 'Meta description с городом',
            'header_with_city' => 'h1 заголовок с городом',
            'bottom_text' => 'Текст страницы поиска'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeCategories()
    {
        return $this->hasMany(ResumeCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasMany(Resume::className(), ['id' => 'resume_id'])
            ->viaTable('resume_category', ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancyCategories()
    {
        return $this->hasMany(VacancyCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasMany(Vacancy::className(), ['id' => 'vacancy_id'])
            ->viaTable('vacancy_category', ['category_id' => 'id']);
    }

}
