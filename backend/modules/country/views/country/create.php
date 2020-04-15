<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Country */

$this->title = 'Создать страну';
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
