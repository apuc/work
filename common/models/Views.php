<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "views".
 *
 * @property int $id
 * @property string $subject_type
 * @property int $subject_id
 * @property int $viewer_id
 * @property int $dt_view
 * @property string $options
 */
class Views extends \yii\db\ActiveRecord
{
    const TYPE_RESUME = 'резюме';
    const TYPE_VACANCY = 'вакансия';

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
            [['subject_id', 'viewer_id', 'dt_view'], 'integer'],
            [['subject_id'], 'required'],
            [['subject_type', 'options'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_type' => 'Тип',
            'subject_id' => 'Идентификатор',
            'viewer_id' => 'Просмотрел',
            'dt_view' => 'Дата просмотра',
            'options' => 'Дополнительно',
        ];
    }

    public function afterFind()
    {
        $this->dt_view = date('d-m-Y', $this->dt_view);
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

    public static function getSubjectType()
    {
        return [
            self::TYPE_RESUME => 'резюме',
            self::TYPE_VACANCY => 'вакансия',
        ];
    }

    public static function getSubject($type, $id)
    {
        if ($type == 'вакансия') {
            $vacancy = Vacancy::find()->where(['id' => $id])->one();
            if(!empty($vacancy)) {
                return $vacancy->post;
            }
            return false;
        }

        if ($type == 'резюме') {
            $resume = Resume::find()->where(['id' => $id])->one();
            if(!empty($resume)) {
                return $resume->title;
            }
            return false;
        }
    }

    public static function findSubject($type)
    {
        if ($type == 'вакансия') {
            return ArrayHelper::map(\common\models\Vacancy::find()->asArray()->all(), 'id',
                'post');
        }

        if ($type == 'резюме') {
            return ArrayHelper::map(\common\models\Resume::find()->asArray()->all(), 'id',
                'title');
        }
    }
}
