<?php
namespace common\models\base;

use common\classes\Debug;
use yii\web\HttpException;

class WorkActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @return bool|void
     */
    public function beforeDelete()
    {
        $list = $this->getRelateDeleteList();

        if(is_array($list) && $list !=[]){
            foreach($list as $relation){
                if($this->$relation){
                    foreach($this->$relation as $item){
                        $item->delete();
                    }
                }
            }
        }
        return parent::beforeDelete();
    }
    /**
     * Массив реляций, которые нужно удалить с текущей моделью
     *
     * @return array
     */
    public function getRelateDeleteList()
    {
        return [];
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        if ($insert && $this->hasAttribute('owner')){
            $this->owner = \Yii::$app->user->id;
        }
    }

}