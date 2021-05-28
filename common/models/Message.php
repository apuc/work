<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $receiver_id
 * @property int $sender_id
 * @property string $subject
 * @property int $subject_id
 * @property string $subject_from
 * @property int $subject_from_id
 * @property int $is_read
 * @property int $deleted_by_receiver
 * @property int $deleted_by_sender
 * @property int $created_at
 * @property int $updated_at
 */
class Message extends WorkActiveRecord
{

    const SUBJECT_RESUME = 'Resume';
    const SUBJECT_VACANCY = 'Vacancy';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    public function extraFields()
    {
        return ['receiver', 'sender', 'subject0', 'subject0_from'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_id', 'sender_id', 'subject_id', 'subject_from_id', 'is_read', 'deleted_by_receiver', 'deleted_by_sender'], 'integer'],
            [['text'], 'string'],
            [['title', 'subject', 'subject_from'], 'string', 'max'=>255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'receiver_id' => 'Receiver ID',
            'sender_id' => 'Sender ID',
            'subject' => 'Subject',
            'subject_id' => 'Subject ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getSender(){
        return $this->hasOne(User::className(), ['id'=>'sender_id']);
    }

    public function getReceiver(){
        return $this->hasOne(User::className(), ['id'=>'receiver_id']);
    }

    public function getSubject0(){
        if($this->subject === self::SUBJECT_RESUME)
            return $this->hasOne(Resume::className(), ['id'=>'subject_id']);
        if($this->subject === self::SUBJECT_VACANCY)
            return $this->hasOne(Vacancy::className(), ['id'=>'subject_id']);
        return null;
    }
    public function getSubject0_from(){
        if($this->subject_from === self::SUBJECT_RESUME)
            return $this->hasOne(Resume::className(), ['id'=>'subject_from_id']);
        if($this->subject_from === self::SUBJECT_VACANCY)
            return $this->hasOne(Vacancy::className(), ['id'=>'subject_from_id']);
        return null;
    }

}
