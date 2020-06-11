<?php

use common\models\Company;
use dektrium\user\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\company\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">
    <p>
        <?= Html::a('Создать баннер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="mobile-table">
        <div class="mobile-table-control"></div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'logo_url',
                    'format'    => 'html',
                    'value' => function($model) {
                        return '<img alt="" width="100px" src="'.$model->logo_url.'">';
                    },
                ],
                [
                    'attribute' => 'image_url',
                    'format'    => 'html',
                    'value' => function($model) {
                        return '<img alt="" width="100px" src="'.$model->image_url.'">';
                    },
                ],
                [
                    'attribute' => 'owner',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                    'format'    => 'text',
                    'value' => function ($model) {
                        return $model->ownerUser->username;
                    },
                ],
                [
                    'attribute' => 'company_id',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                    'format'    => 'text',
                    'value' => function ($model) {
                        return $model->company->name;
                    },
                ],
                [
                    'attribute' => 'priority',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                ],
                [
                    'attribute' => 'created_at',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                    'value' => function ($model) {
                        return $model->humanCreatedAt;
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                    'value' => function ($model) {
                        return $model->humanUpdatedAt;
                    }
                ],
                [
                    'attribute' => 'description',
                    'format' => 'text',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                    'value' => function ($model) {
                        return StringHelper::truncate($model->description, 100);
                    }
                ],
                [
                    'attribute' => 'is_active',
                    'contentOptions' => ['style' => 'white-space: normal;'],
                    'value' => function ($model) {
                        return $model->is_active ? 'Да' : 'Нет';
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
