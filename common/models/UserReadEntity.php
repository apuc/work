<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_read_entity".
 *
 * @property int $id
 * @property int $user_id Пользователь, просмотревший сущность
 * @property string $subject Сущность
 * @property int $subject_id ID сущности
 *
 * @property User $user
 */
class UserReadEntity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_read_entity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'subject', 'subject_id'], 'required'],
            [['user_id', 'subject_id'], 'integer'],
            [['subject'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь, просмотревший сущность',
            'subject' => 'Сущность',
            'subject_id' => 'ID сущности',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
