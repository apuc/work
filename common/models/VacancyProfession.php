<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vacancy_profession".
 *
 * @property int $profession_id
 * @property int $vacancy_id
 * @property int $match_type
 * @property int $status
 *
 * @property Professions $profession
 * @property Vacancy $vacancy
 */
class VacancyProfession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_profession';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profession_id', 'vacancy_id', 'match_type'], 'required'],
            [['profession_id', 'vacancy_id', 'match_type', 'status'], 'integer'],
            [['profession_id', 'vacancy_id'], 'unique', 'targetAttribute' => ['profession_id', 'vacancy_id']],
            [['profession_id'], 'exist', 'skipOnError' => true, 'targetClass' => Professions::className(), 'targetAttribute' => ['profession_id' => 'id']],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profession_id' => 'Профессия',
            'vacancy_id' => 'Вакансия',
            'match_type' => 'Тип совпадения',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfession()
    {
        return $this->hasOne(Professions::className(), ['id' => 'profession_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::className(), ['id' => 'vacancy_id']);
    }
}
