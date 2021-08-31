<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Logo */

$this->title = 'Создать логотип';
$this->params['breadcrumbs'][] = ['label' => 'Logos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
