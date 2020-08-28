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
 * @property string $alias
 * @property float $price
 */
class ServicePrice extends WorkActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'string', 'max' => 255],
            [['price'], 'number'],
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
            'icon' => 'Иконка'
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
     * @return \yii\db\ActiveQuery
     */
    public function getMetaData()
    {
        return $this->hasOne(MetaData::className(), ['category_id' => 'id']);
    }

}
