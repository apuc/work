<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SpecFilters*/

$this->title = 'Создать специальный фильтр';
$this->params['breadcrumbs'][] = ['label' => 'Фильтр', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec_filters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
