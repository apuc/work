<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetaData */

$this->title = 'Create Meta Data';
$this->params['breadcrumbs'][] = ['label' => 'Meta Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
