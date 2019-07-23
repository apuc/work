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

    <?= $form->field($searchModel, 'excel')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitInput('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
    <h4>Структура документа должен представлять следующую последовательность данных: |Почта|Имя|</h4>

    <p>
        <?= Html::a('Создать рассылку', ['send'], ['class' => 'btn btn-success']) ?>
    </p>
<?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'email',
                'template',
                'status',
                'dt_send',
                'subject',
            ['class' => 'yii\grid\ActionColumn'],
            ],
]); ?>


</div>
