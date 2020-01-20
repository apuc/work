<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dialog".
 *
 * @property int $id
 * @property int $owner
 * @property int $status
 *
 * @property DialogMessage[] $dialogMessages
 * @property DialogUser[] $dialogUsers
 */
class Dialog extends \yii\db\ActiveRecord
{

    const SOFT_DELETE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dialog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner' => 'Owner',
            'status' => 'Status',
        ];
    }
    public function extraFields()
    {
        return ['dialogMessages', 'dialogUsers', 'users', 'lastMessage'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogMessages()
    {
        return $this->hasMany(DialogMessage::className(), ['dialog_id' => 'id'])->orderBy('id DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogUsers()
    {
        return $this->hasMany(DialogUser::className(), ['dialog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('dialogUsers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastMessage()
    {
        return $this->getDialogMessages()->limit(1);
    }

}
