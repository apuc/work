<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\key_value\models\KeyValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рассылка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-delivery-index">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <?= $form->field($file, 'letter')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitInput('Submit', ['class' => 'btn btn-success']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Шаблон',
                'value' => function($model) {
                    return $model;
                }
            ],
            ['class' => 'yii\grid\ActionColumn' , 'template' => '{delete}'],
        ],
    ]); ?>
</div>
