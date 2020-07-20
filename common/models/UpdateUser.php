<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "update_user".
 *
 * @property int $user_id
 * @property int $update_id
 *
 * @property Update $update
 * @property User $user
 */
class UpdateUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'update_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'update_id'], 'required'],
            [['user_id', 'update_id'], 'integer'],
            [['user_id', 'update_id'], 'unique', 'targetAttribute' => ['user_id', 'update_id']],
            [['update_id'], 'exist', 'skipOnError' => true, 'targetClass' => Update::className(), 'targetAttribute' => ['update_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'update_id' => 'Update ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdate()
    {
        return $this->hasOne(Update::className(), ['id' => 'update_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
