<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\KeyValue */

$this->title = 'Изменить переменную: ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Переменные', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->key, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="key-value-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
