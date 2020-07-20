<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Update */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Обновления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="update-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить это обновление?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'text:html',
            ['attribute' => 'created_at', 'format' => ['date', 'php:d.m.Y H:i:s']],
            ['attribute' => 'updated_at', 'format' => ['date', 'php:d.m.Y H:i:s']],
        ],
    ]) ?>

</div>
