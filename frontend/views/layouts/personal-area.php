<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\PersonalAreaAsset;
use yii\helpers\Html;

PersonalAreaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="../images/favicon.png" />
</head>
<body>
<?php $this->beginBody() ?>
<div class="body-wrapper">
    <?= \frontend\widgets\PersonalAreaSidebar::widget(); ?>
    <?= \frontend\widgets\PersonalAreaHeader::widget(); ?>
    <!-- partial -->
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <?=$content?>

        <?= \frontend\widgets\PersonalAreaFooter::widget(); ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>