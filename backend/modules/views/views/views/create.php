<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Views */

$this->title = 'Создать просмотр';
$this->params['breadcrumbs'][] = ['label' => 'Просмотры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="views-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
