<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\views\models\ViewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Просмотры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="views-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить просмотр', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'company_id',
            'vacancy_id',
            'viewer_id',
            'dt_view',
            //'options:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
