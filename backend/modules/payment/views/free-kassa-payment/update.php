<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FKPayment */

$this->title = 'Изменить платёж Free-Kassa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Платежы Free-Kassa', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fkpayment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
