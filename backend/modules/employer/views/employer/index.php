<?php

use common\models\Employer;
use dektrium\user\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\employer\models\EmployerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'format'    => 'text',
                'value' => function($model)
                {
                    return User::findOne($model->user_id)->username;
                },
                'filter'    => \kartik\select2\Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'data' => \yii\helpers\ArrayHelper::map(User::find()->asArray()->all(),'id', 'username'),
                        'options' => ['placeholder' => 'Выберите пользователя...','class' => 'form-control'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
            ],
            'first_name',
            'second_name',
//            [
//                'attribute' => 'birth_date',
//                'value' => function($model){
//                    return date('d.m.Y', strtotime($model->birth_date));
//                }
//            ],
            'created_at',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->status){
                        case Employer::STATUS_INACTIVE: return 'Не активен';
                    }
                    return 'Активен';
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'status', [
                    Employer::STATUS_ACTIVE => 'Активен',
                    Employer::STATUS_INACTIVE => 'Не активен',
                ], [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
