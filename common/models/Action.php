<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "action".
 *
 * @property int $id
 * @property string $type
 * @property string $subject
 * @property int $subject_id
 * @property int $count
 */
class Action extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_id', 'count'], 'integer'],
            [['type', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'subject' => 'Subject',
            'subject_id' => 'Subject ID',
            'count' => 'Count',
        ];
    }
}
