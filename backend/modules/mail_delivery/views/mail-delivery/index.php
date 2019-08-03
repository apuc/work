<?php

use kartik\date\DatePicker;
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

    <?= $form->field($searchModel, 'excel')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitInput('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
    <h4>Структура документа должен представлять следующую последовательность данных: |Почта|Имя|</h4>
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'email',
                'template',
                [
                  'attribute' => 'status',
                  'value' => function($model) {
                        return \common\models\SendMail::getStatusName($model->status);
                  },
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'status',
                        'data' => \common\models\SendMail::getStatusList(),
                        'options' => ['placeholder' => 'Выберите статус...', 'class' => 'form-control'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
            [
                    'attribute' => 'dt_send',
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' =>  'dt_send',
                    'type' => DatePicker::TYPE_INPUT,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите дату'],
                ]),
            ],
                'subject',
                [
                    'label' => 'Отправить письмо',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a('Отправка письма',['send', 'id' => $model->id],['class' => 'btn btn-success btn-xs']);
                    }
                ],
            ['class' => 'yii\grid\ActionColumn'],
            ],
]); ?>


</div>
