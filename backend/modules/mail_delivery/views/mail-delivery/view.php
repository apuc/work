<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Письмо №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список писем', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="mail-view">
        <p>
            <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'email',
                'template',
                'status',
                'dt_send',
                'subject',
            ],
        ]) ?>
    </div>
