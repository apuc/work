<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\professions\models\Professions */

$this->title = 'Создать профессию';
$this->params['breadcrumbs'][] = ['label' => 'Профессии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
