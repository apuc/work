<?php

use dektrium\user\models\Token;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $token Token */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['reset-password/recovery', 'token' => $token->code]);
?>
<div class="password-reset">

    <p>Пройдите по ссылке ниже для восстановления пароля</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
