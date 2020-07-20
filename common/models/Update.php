<?php

namespace common\models;

use frontend\models\user\RegUserForm;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "update".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $text Текст
 * @property int $created_at Дата создания
 * @property int $updated_at Дата последнего изменения
 */
class Update extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'update';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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

    public function extraFields()
    {
        return ['is_read'];
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
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего изменения',
        ];
    }

    public function getIs_read() {
        return (bool)UpdateUser::findOne(['update_id'=>$this->id, 'user_id'=>Yii::$app->user->id]);
    }

    public function getUpdateUser() {
        return $this->hasMany(UpdateUser::className(), ['update_id'=>'id']);
    }
}
