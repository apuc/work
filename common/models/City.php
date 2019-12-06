<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;

/**
 * This is the model class for table "geobase_city".
 *
 * @property int $id
 * @property string $name
 * @property string $prepositional
 * @property string $image
 * @property string $region_id
 * @property string $latitude
 * @property string $longitude
 * @property string $status
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_description
 * @property string $header
 *
 * @property Region $region
 *
 */
class City extends WorkActiveRecord
{
    const TYPE_HIDDEN = 0;
    const TYPE_SHOWN = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geobase_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'prepositional', 'image', 'slug', 'meta_title', 'meta_description', 'header'], 'string', 'max' => 50],
            [['region_id', 'status'], 'integer'],
            [['latitude', 'longitude'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'latitude' => 'Широта',
            'longitude' => 'Долгота',
            'region_id' => 'Область',
            'image' => 'Фотография',
            'slug' => 'Slug',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'header' => 'h1 заголовок',
        ];
    }

    public function beforeSave($insert)
    {
        if($insert)
            $this->slug = \common\classes\LocoTranslitFilter::cyrillicToLatin($this->name, 100, true);
        return parent::beforeSave($insert);
    }

    public static function getStatusList()
    {
        return [
            self::TYPE_HIDDEN => 'Скрыт',
            self::TYPE_SHOWN => 'Выводится',
        ];
    }

    public static function getStatusName($id)
    {
        return self::getStatusList()[$id];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
