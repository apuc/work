<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\professions\models\ProfessionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Professions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professions-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'title',
            'slug',
            'genitive',
            [
                'header' => 'Статус',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{change}',
                'buttons' => [
                    'change' => function ($url,$model) {
                    if ($model->status == 1){
                        return Html::a('Скрыть', $url, ['class' => 'ajax-status', 'data-id' => $model->id, 'data-status' => '0']);
                    }else{
                        return Html::a('Показать', $url, ['class' => 'ajax-status', 'data-id' => $model->id, 'data-status' => '1']);
                    }
                    },
                ],
            ],
            'instrumental',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
