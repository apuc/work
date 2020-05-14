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
 * @property string $search_page_title Заголовок страницы поиска
 * @property string $search_page_header H1 страницы поиска
 * @property string $search_page_description Описание страницы поиска
 * @property string $news_meta_title Заголовок страницы новостей
 * @property string $news_meta_description Описание страницы новостей
 * @property string $news_meta_header h1 заголовок страницы новостей
 * @property string $news_about О старнице новостей
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
            [['meta_description', 'main_page_text', 'main_page_mobile_text', 'search_page_description'], 'string'],
            [['name', 'slug', 'meta_title', 'meta_header', 'main_page_background_image', 'main_page_emblem', 'search_page_title', 'search_page_header',
                'news_meta_title', 'news_meta_description', 'news_meta_header', 'news_about'], 'string', 'max' => 255],
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
            'search_page_title' => 'Заголовок страницы поиска',
            'search_page_header' => 'H1 страницы поиска',
            'search_page_description' => 'Описание страницы поиска',
            'news_meta_title' => 'Заголовок страницы новостей',
            'news_meta_description' => 'Описание страницы новостей',
            'news_meta_header' => 'h1 заголовок страницы новостей',
            'news_about' => 'Немного о сайте новостей',
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
