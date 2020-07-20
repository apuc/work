<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Update */

$this->title = 'Изменение обновления: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Обновления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="update-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
