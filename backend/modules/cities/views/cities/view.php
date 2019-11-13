<?php

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

use yii\helpers\Html;
use yii\widgets\DetailView; ?>

<div class="cities-view">
    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этот город?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute'=>'image',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->image, ['height'=>'300px']);
                }
            ],
            'region_id',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\City::getStatusName($model->status);
                }
            ],
            'latitude',
            'longitude',
        ],
    ]) ?>

</div>