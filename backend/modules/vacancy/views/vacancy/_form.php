<?php

use common\models\Category;
use common\models\City;
use common\models\Employer;
use common\models\Vacancy;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vacancy-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        $companiesMap = [];
        foreach (\common\models\Company::find()->each() as $company) {
            $companiesMap[$company->id] = $company->name?:$company->contact_person;
        }
    ?>
    <?= $form->field($model, 'company_id')->widget(Select2::className(),
        [
            'data' => $companiesMap,
            'options' => ['placeholder' => 'Начните вводить имя работодателя ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(City::find()->where(['status'=>1])->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'main_category_id')->label('Главная категория')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Начните вводить название категории ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'category')->label('Дополнительные категории')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Начните вводить название категории ...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsibilities')->textarea() ?>

    <?= $form->field($model, 'employment_type_id')->dropDownList(ArrayHelper::map(\common\models\EmploymentType::find()->all(), 'id', 'name'), [ 'class' => 'form-control', 'prompt' => '' ] ) ?>

    <?= $form->field($model, 'min_salary')->textInput() ?>

    <?= $form->field($model, 'max_salary')->textInput() ?>

    <?= $form->field($model, 'qualification_requirements')->textarea() ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'work_experience')->dropDownList(Vacancy::$experiences, [ 'class' => 'form-control', 'prompt' => '' ] ) ?>

    <?= $form->field($model, 'education')->dropDownList([
        'Не имеет значения' => 'Не имеет значения',
        'Среднее' => 'Среднее',
        'Неполное высшее' => 'Неполное высшее',
        'Высшее' => 'Высшее'
    ]) ?>

    <?= $form->field($model, 'working_conditions')->textarea() ?>

    <?= $form->field($model, 'status')->dropDownList([
        Vacancy::STATUS_ACTIVE => 'Активна',
        Vacancy::STATUS_INACTIVE => 'Не активна',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
