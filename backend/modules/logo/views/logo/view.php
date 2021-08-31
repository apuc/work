<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Logo */

$this->params['breadcrumbs'][] = ['label' => 'Логотипы компаний для страницы /employer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="logo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            [
                'attribute' => 'company_id',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format'    => 'text',
                'value' => function ($model) {
                    return $model->company->name;
                },
            ],
            [
                'attribute' => 'image',
                'format'    => 'html',
                'value' => function($model) {
                    return '<img alt="" width="100px" src="'.$model->image.'">';
                },
            ],
            [
                'attribute' => 'active_until',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format'    => 'text',
                'value' => function ($model) {
                    return date('d-m-y',$model->active_until);
                },
            ],
        ],
    ]) ?>

</div>
