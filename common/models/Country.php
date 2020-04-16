<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "geobase_country".
 *
 * @property int $id
 * @property string $name Название
 * @property string $slug Название латинскими буквами
 * @property string $meta_title Заголовок главной старницы
 * @property string $meta_description Описание главной страницы
 * @property string $meta_header h1 заголовок главной страницы
 * @property string $main_page_text Текст на главной странице
 * @property string $main_page_mobile_text Текст на главной странице
 * @property string $main_page_background_image Фоновое изображение главной страницы
 * @property string $main_page_emblem Эмблема главной страницы
 *
 * @property Region[] $regions
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geobase_country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['meta_description', 'main_page_text', 'main_page_mobile_text'], 'string'],
            [['name', 'slug', 'meta_title', 'meta_header', 'main_page_background_image', 'main_page_emblem'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Название латинскими буквами',
            'meta_title' => 'Заголовок главной старницы',
            'meta_description' => 'Описание главной страницы',
            'meta_header' => 'h1 заголовок главной страницы',
            'main_page_text' => 'Текст на главной странице',
            'main_page_mobile_text' => 'Текст на главной странице для мобильных устройств',
            'main_page_background_image' => 'Фоновое изображение главной страницы',
            'main_page_emblem' => 'Эмблема главной страницы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['country_id' => 'id']);
    }
}
