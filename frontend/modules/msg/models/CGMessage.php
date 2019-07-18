<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.06.19
 * Time: 17:59
 */

namespace frontend\modules\msg\models;


use vision\messages\models\Messages;

/**
 * Class CGMessage
 * @package frontend\modules\msg\models
 * @property $subject_id
 * @property $subject_type
 */
class CGMessage extends Messages
{
    public function rules()
    {
        $parent = parent::rules();
        return array_merge($parent,[
            [['subject_id'],'integer'],
            [['subject_type'],'string'],
        ]);
    }
}