<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "professions".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $genitive
 * @property string $instrumental
 *
 * @property MetaData $metaData
 */
class Professions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'professions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'genitive', 'instrumental'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'slug' => 'Slug',
            'genitive' => 'Родительный',
            'instrumental' => 'Творительный',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetaData()
    {
        return $this->hasOne(MetaData::className(), ['profession_id' => 'id']);
    }
}
