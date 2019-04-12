<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'], 'required']
        ];
    }

    public function extraFields()
    {
        return ['resume', 'resumeCategories'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
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

    /**
     * @return int|string
     */
    public function getVacancy_count()
    {
        return $this->getVacancyCategories()->count();
    }
}
