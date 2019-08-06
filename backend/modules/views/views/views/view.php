<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Views */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Просмотры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="views-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            [
                'attribute' => 'subject_type',
            ],
            [
                'attribute' => 'subject_id',
                'value' => function ($model) {
                    return \common\models\Views::getSubject($model->subject_type, $model->subject_id);
                },
            ],
            [
                'attribute' => 'viewer_id',
                'value' => function ($model) {
                    return \common\models\Views::getViewer($model->viewer_id)['username'];
                },
            ],
            'dt_view',
//            'options:ntext',
        ],
    ]) ?>

</div>
