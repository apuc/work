<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\update\models\UpdateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обновления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="update-index">
    <p>
        <?= Html::a('Создать обновление', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format' => 'html'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
