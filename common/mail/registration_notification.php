<?php

/* @var $this yii\web\View */
/* @var $employer common\models\Employer */
/* @var $token \dektrium\user\models\Token */

use yii\helpers\Url; ?>
Здравствуйте, <?=$employer->second_name?> <?=$employer->first_name?><br>
Спасибо за регистрацию на <a href="<?=Url::base(true)?>">rabota.today</a>
<?php if($token):?>
<a href="<?=Url::base(true)?>/confirm/<?=$user->id?>/<?=$token->code?>">Ссылка для подтверждения аккаунта</a>
<?php endif?>