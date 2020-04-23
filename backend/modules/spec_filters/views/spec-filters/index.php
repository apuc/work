<?php

use common\models\SpecFilters;
use common\models\Vacancy;
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
            [
                'attribute' => 'field_name',
                'value' => function($model) {
                    return (new Vacancy())->attributeLabels()[$model->field_name];
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'field_name',
                    (new Vacancy())->attributeLabels(),
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
            [
                'attribute'=>'sign',
                'filter'    => Html::activeDropDownList( $searchModel, 'sign',
                    SpecFilters::$signs,
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
            'value',
            [
                'attribute'=>'dynamic',
                'value'=>function($model){
                    return $model->dynamic==1?"Да":"Нет";
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'dynamic',
                    ['Нет', 'Да'],
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return $model->status==1?"Включен":"Отключен";
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'status',
                    ['Отключен', 'Включен'],
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
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
