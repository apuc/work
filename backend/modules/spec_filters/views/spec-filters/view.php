<?php

use common\models\Vacancy;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SpecFilters */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Filters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="skill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            [
                'attribute' => 'field_name',
                'value' => function($model) {
                    return (new Vacancy())->attributeLabels()[$model->field_name];
                },
            ],
            'sign',
            'value',
            [
                'attribute'=>'dynamic',
                'value'=>function($model){
                    return $model->dynamic==1?"Да":"Нет";
                }
            ],
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return $model->status==1?"Включен":"Отключен";
                }
            ],
            [
                'attribute'=>'icon',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->icon, ['height'=>'75px']);
                }
            ],
            'color',
        ],
    ]) ?>

</div>
