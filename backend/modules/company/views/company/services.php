<?php

use common\models\Company;
use kartik\select2\Select2;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">


    <p>
        Оставшееся количество поднятий вакансий с закреплением: <?=$model->raise_with_anchor_count?:0?>.
        Активны до: <?=($model->raise_with_anchor_until > time()) ? date('d-m-Y', $model->raise_with_anchor_until):'Не активны';?>
    </p>

    <p>
        Безлимитные вакансии до: <?=($model->unlimited_vacancies_until > time()) ? date('d-m-Y', $model->unlimited_vacancies_until):'Не активно';?>
    </p>


    <?php $form = ActiveForm::begin([
        'action' => '/secure/company/company/activate-tariff'
    ]); ?>
    <?= Html::hiddenInput('tariff', 'standard')?>
    <?= Html::hiddenInput('company_id', $model->id)?>
    <?= Html::submitButton('Активировать тарифф "Стандартный"')?>
    <?php ActiveForm::end(); ?>

</div>
