<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Promocode */

$this->title = 'Создать несколько промокодов';
$this->params['breadcrumbs'][] = ['label' => 'Промокоды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocode-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
