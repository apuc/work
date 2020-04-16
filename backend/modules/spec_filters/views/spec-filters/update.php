<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SpecFilters*/

$this->title = 'Изменить специальный фильтр: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фильтр', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="skill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>