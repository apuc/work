<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FKPayment */

$this->title = 'Create Fk Payment';
$this->params['breadcrumbs'][] = ['label' => 'Fk Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fkpayment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
