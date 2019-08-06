<?php

namespace common\models;

use common\classes\Debug;
use Yii;

/**
 * This is the model class for table "views".
 *
 * @property int $id
 * @property int $company_id
 * @property int $vacancy_id
 * @property int $viewer_id
 * @property int $dt_view
 * @property string $options
 */
class Views extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'views';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'vacancy_id', 'viewer_id', 'dt_view'], 'integer'],
            [['vacancy_id'], 'required'],
            [['options'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'vacancy_id' => 'Вакансия',
            'viewer_id' => 'Просмотрел',
            'dt_view' => 'Дата просмотра',
            'options' => 'Дополнительно',
        ];
    }

    public function afterFind()
    {
        $this->dt_view = date('d-m-Y', $this->dt_view);
    }

    public static function getCompany($id)
    {
        return Company::find()->where(['id' => $id])->one();
    }

    public static function getVacancy($id)
    {
        return Vacancy::find()->where(['id' => $id])->one();
    }

    public static function getViewer($id)
    {
        $viewer['username'] = 'Гость';

        if ($id !== null) {
            $viewer = User::find()->where(['id' => $id])->asArray()->one();
        }

        return $viewer;
    }

    public static function getAllUsers()
    {
        $users = \yii\helpers\ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'id', 'username');
        $users[0] = 'Гость';

        return $users;
    }
}
