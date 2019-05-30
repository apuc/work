<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Employer */

$this->title = 'Изменить сотрудника: ' . $model->second_name.' '.$model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->second_name.' '.$model->first_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="employer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
