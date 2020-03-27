<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetaData */
if($model->category)
    $this->title = "Изменить метаданные для категории ". $model->category->name;
if($model->profession)
    $this->title = "Изменить метаданные для профессии ". $model->profession->title;
$this->params['breadcrumbs'][] = ['label' => 'Мета данные', 'url' => ['index']];
if($model->category)
    $this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['view', 'id' => $model->id]];
if($model->profession)
    $this->params['breadcrumbs'][] = ['label' => $model->profession->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="meta-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
