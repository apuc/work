<?php

/* @var $this yii\web\View */
/* @var $employer common\models\Employer */

use yii\helpers\Url; ?>
Здравствуйте, <?=$employer->second_name?> <?=$employer->first_name?><br>
Спасибо за регистрацию на <a href="<?=Url::base(true)?>">rabota.today</a>