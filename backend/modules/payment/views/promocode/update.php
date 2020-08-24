<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Promocode */

$this->title = 'Изменить промокод: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Промокоды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="promocode-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
