<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FKCurrency */

$this->title = 'Создать валюту Free-Kassa';
$this->params['breadcrumbs'][] = ['label' => 'Валюты Free-Kassa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fkcurrency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
