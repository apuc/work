<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\spec_filters\models\SpecFiltersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Специальные фильтры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec_filters-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать специальный фильтр', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'slug',
            'field_name',
            'sign',
            'value',
            'dynamic',
            'status',
            [
                'attribute'=>'icon',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->icon, ['height'=>'75px']);
                }
            ],
            'color',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
