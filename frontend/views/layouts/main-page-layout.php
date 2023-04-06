<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\MainAsset;
use frontend\widgets\Footer;
use frontend\widgets\GoogleAnalytics;
use frontend\widgets\Modals;
use frontend\widgets\VKPixel;
use frontend\widgets\YandexMetrika;
use yii\helpers\Html;

MainAsset::register($this);
Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mykassa-verification" content="f11816c8f45eb021130d15e76e4d0c17" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="../images/favicon.png" />
    <?=YandexMetrika::widget()?>
    <?=GoogleAnalytics::widget()?>
    <?=VKPixel::widget()?>
</head>
<body>
<div class="root">
<?php $this->beginBody() ?>
    <?=$content?>
</div>
<?=Modals::widget();?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>