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
 * @property string $status
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_description
 * @property string $header
 * @property string $bottom_text
 * @property string $resume_meta_title
 * @property string $resume_meta_description
 * @property string $resume_header
 * @property string $resume_bottom_text
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
            [['name'], 'string', 'max' => 50],
            [['name', 'region_id'], 'required'],
            [['prepositional', 'image', 'slug', 'meta_title', 'header', 'resume_meta_title', 'resume_header'], 'string', 'max' => 255],
            [['meta_description', 'bottom_text', 'resume_meta_description', 'resume_bottom_text'], 'string'],
            [['region_id', 'status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'region_id' => 'Область',
            'image' => 'Фотография',
            'slug' => 'Slug',
            'meta_title' => 'vacancy meta title',
            'meta_description' => 'Vacancy meta description',
            'header' => 'h1 заголовок вакансий',
            'bottom_text' => 'Текст страницы поиска вакансий',
            'resume_meta_title' => 'Resume meta title',
            'resume_meta_description' => 'Resume meta description',
            'resume_header' => 'h1 заголовок резюме',
            'resume_bottom_text' => 'Текст страницы поиска резюме'
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
