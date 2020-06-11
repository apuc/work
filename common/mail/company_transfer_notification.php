<?php

/* @var $this yii\web\View */
/* @var $company common\models\Company */
/* @var $token \dektrium\user\models\Token */
/* @var $password string */

use yii\helpers\Url; ?>
Здравствуйте<br>
На вашу почту была перенесена компания <?=$company->name?> на <a href="<?=Url::base(true)?>">rabota.today</a>
Ваш временный пароль: <?=$password?>
<?php if($token):?>
<a href="<?=Url::base(true)?>/confirm/<?=$user->id?>/<?=$token->code?>">Ссылка для подтверждения аккаунта</a>
<?php endif?>