<?php


namespace common\models;

use common\models\base\WorkActiveRecord;

/**
 * This is the model class for table "spec_filters".
 *
 * @property integer $id
 * @property string $slug
 * @property string $field_name
 * @property string $name
 * @property string $sign
 * @property string $value
 * @property integer $dynamic
 * @property integer $status
 * @property string $icon
 * @property string $color
 */

class SpecFilters extends WorkActiveRecord

{
    public static function tableName()
    {
        return 'spec_filters';
    }

    public function rules()
    {
        return [
            [['id', 'dynamic', 'status'], 'integer'],
            [['slug', 'field_name', 'name', 'value'], 'string', 'max' => 255],
            [['sign'], 'string', 'max' => 15],
            [['icon', 'color'], 'string'],
            [['slug', 'field_name', 'name', 'value'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'field_name' => 'Поля имя',
            'name' => 'Имя',
            'sign' => 'Знак',
            'value' => 'Значение',
            'dynamic' => 'Динамическое',
            'status' => 'Статус',
            'icon' => 'Иконка',
            'color' => 'Цвет',
        ];
    }

}