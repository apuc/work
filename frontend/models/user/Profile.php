<?php
/**
 * Created by PhpStorm.
 * User: Офис
 * Date: 14.07.2016
 * Time: 12:34
 */

namespace frontend\models\user;


class Profile extends \dektrium\user\models\Profile
{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'avatar';
        $scenarios['update'][]   = 'avatar';
        $scenarios['register'][] = 'avatar';
        $scenarios['create'][]   = 'avatar_little';
        $scenarios['update'][]   = 'avatar_little';
        $scenarios['register'][] = 'avatar_little';
        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();
        // add some rules

        $rules['avatarLength']   = ['avatar', 'string', 'max' => 255];
        $rules['avatarLittleLength']   = ['avatar_little', 'string', 'max' => 255];

        return $rules;
    }


}