<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */

$this->title = 'Создать резюме';
$this->params['breadcrumbs'][] = ['label' => 'Резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
