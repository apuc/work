<?php

use common\models\Promocode;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Promocode */

$this->title = "Промокод: $model->code";
$this->params['breadcrumbs'][] = ['label' => 'Промокоды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="promocode-view">
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
            'code',
            [
                'attribute' => 'usages_left',
                'value' => function($model) {
                    if ($model->usages_left === null) {
                        return 'Неограничено';
                    }
                    return $model->usages_left;
                }
            ],
            [
                'attribute' => 'action',
                'value' => function($model) {
                    $actions = Promocode::getActions();
                    return isset($actions[$model->action])?$actions[$model->action]:null;
                }
            ],
            ['attribute' => 'active_until', 'format' => ['date', 'php:d-m-Y']],
            ['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y']],
        ],
    ]) ?>

</div>
