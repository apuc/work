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
            [['name', 'image'], 'string', 'max' => 255],
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
