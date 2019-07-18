<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 11.06.19
 * Time: 15:28
 */

namespace frontend\modules\msg\components;

use common\classes\Debug;
use vision\messages\components\MyMessages;

class CGMessages extends MyMessages
{
    public static function getCurrentUsers($id)
    {
        $query = new \yii\db\Query();
        $query->select(['user.id', 'user.username'])->distinct();
        $query->from('user');
        $query->join('JOIN','messages','user.id = messages.from_id OR user.id = messages.whom_id');
        $query->Where(['=','messages.from_id', $id]);
        $query->orWhere(['=','messages.whom_id',$id]);
        $query->andWhere(['!=','user.id',$id]);

        return $query->all();
    }

    public static function getOneUser($from, $whom)
    {
        $query = new \yii\db\Query();
        $query->select(['user.id', 'user.username']);
        $query->from('user');
        $query->where(['=', 'user.id', $whom]);

        return $query->all();
    }


}