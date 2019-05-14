<?php
namespace common\models\base;

use yii\db\ActiveRecord;

class WorkActiveRecord extends ActiveRecord
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
                    if(is_array($this->$relation)){
                        foreach($this->$relation as $item){
                            $item->delete();
                        }
                    } else {
                        $this->$relation->delete();
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
        return true;
    }

}