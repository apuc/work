<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Views */

$this->title = 'Редактировать просмотр: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Просмотры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="views-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
