<?php


/** @var HttpException $exception */

use yii\helpers\Html;

$this->title = "Ошибка";
?>

<?php
//\common\classes\Debug::dd($exception);
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\MainAsset;
use frontend\widgets\Footer;
use frontend\widgets\GoogleAnalytics;
use frontend\widgets\Modals;
use frontend\widgets\SecondHeader;
use frontend\widgets\VKPixel;
use frontend\widgets\YandexMetrika;
use yii\web\HttpException;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="/images/favicon.png" />
    <?=YandexMetrika::widget()?>
    <?=GoogleAnalytics::widget()?>
    <?=VKPixel::widget()?>
</head>
<body>
<div class="root">
    <?php $this->beginBody() ?>
    <?=SecondHeader::widget()?>
    <section class="page-error">
        <div class="container">
            <p class="error-page-code"><?=$exception->statusCode?></p>
            <?php if($exception->statusCode != 0 && $exception->statusCode != 500):?>
            <p class="mb15 error-page-description"><?=$exception->getMessage()?></p>
            <?php else:?>
            <p class="mb15 error-page-description">Возникла внутренняя ошибка сервера.</p>
            <?php endif ?>
            <a href="/">
                на главную
            </a>
            <p class="mb15">Сайт поиска работы №1 в ДНР и ЛНР. </p>
            <p>
                Разместите резюме и получите приглашения на работу от лучших работодателей.<br>
                Размещение вакансий и резюме - бесплатно. Размести сегодня - улучши качество жизни завтра!<br>
                Поиск работы в ДНР и ЛНР - это rabota.today.
            </p>
            <div class="page-error__soc">
                <a class="vk-bg" rel="nofollow" target="_blank" href="https://vk.com/rabotad0netsk">
                    <img src="/images/vk.svg" alt="" role="presentation"/>
                </a>
            </div>
            <img class="page-error__dots" src="/images/dots__small.png" alt="">
        </div>
    </section>
    <?=Footer::widget()?>
</div>
<?=Modals::widget()?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
