<?php
/* @var $login_form \dektrium\user\models\LoginForm */

/* @var $registration_form \dektrium\user\models\RegistrationForm */

use common\classes\Debug;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
?>
<div class="modal-block jsModal">
    <div class="modal-overlay jsModalClose">
    </div>
    <div class="modal-position">
        <div class="modal-close jsModalClose"><span></span><span></span>
        </div>
        <div class="modal-style modal-login jsModalLogin">
            <h2>Вход
            </h2>
            <?php

            $form = ActiveForm::begin([
                'action' => '/user/login',
                'id' => 'login-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ]); ?>


            <?= $form->field($login_form, 'login',
                ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'jsMail', 'tabindex' => '1', 'placeholder' => 'Электронная почта']]
            )->label(false);
            ?>
            <?= $form->field(
                $login_form,
                'password',
                ['inputOptions' => ['class' => 'jsPass', 'tabindex' => '2', 'placeholder' => 'Пароль']])
                ->passwordInput()->label(false);
            ?>
            <?= Html::submitButton(
                Yii::t('user', 'Войти'),
                ['class' => 'jsBtnLogin jsBtn', 'tabindex' => '4']) ?>
            <?php ActiveForm::end(); ?>
            <div class="modal-style__text"><span>Забыли пароль?</span>
                <button class="jsRegForm">Зарегистрироваться
                </button>
            </div>
        </div>
        <div class="modal-style modal-reg jsModalReg">
            <h2>Регистрация </h2>
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'action' => '/registration/register',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'class' => 'jsModalRegForm'
            ]); ?>
            <input class="jsName" type="text" name="first_name" placeholder="Имя"/>
            <input class="jsSurname" type="text" name="second_name" placeholder="Фамилия"/>
            <input type="hidden" name="register-form[username]" value=""/>
            <?= $form->field($registration_form, 'email', ['inputOptions' => ['class' => 'jsMail', 'placeholder' => 'Электронная почта']])->label(false) ?>
            <?= $form->field(
                $registration_form,
                'password',
                ['inputOptions' => ['class' => 'jsPass', 'placeholder' => 'Пароль']])
                ->passwordInput()->label(false);
            ?>
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'jsBtnReg jsBtn']) ?>
            <?php ActiveForm::end(); ?>
            <div class="modal-style__text"><span>Есть учетная запись?</span>
                <button class="jsLoginForm">Войти</button>
            </div>
        </div>
        <div class="modal-style modal-error jsModalError">
            <h2>Ошибка ввода </h2>
            <div class="modal-style__circle">
                <div class="modal-style__circle__center"><img src="/images/checked.svg" alt="" role="presentation"/>
                </div>
            </div>
            <span class="modal-style__error-text">Вы ввели не верные данные вернитесь и заполните форму верное</span>
        </div>
        <?php if (Yii::$app->controller->uniqueId === 'resume/default' && !Yii::$app->user->isGuest):?>
            <?php /** @var \common\models\Vacancy[] $vacancies */
            $vacancies = \common\models\Vacancy::find()->where(['owner'=> Yii::$app->user->id, 'status'=>\common\models\Vacancy::STATUS_ACTIVE])->all()?>
            <div class="modal-style modal-send-message jsModalMessage">
                <h2>Сообщение</h2>
                <?= Html::beginForm(['/resume/default/send-message'], 'post', ['class' => 'jsModalMessageForm']) ?>
                <select name="vacancy_id" class="jsModalSelectResume">
                    <?php foreach($vacancies as $vacancy): ?>
                        <option value="<?=$vacancy->id?>">
                            <?=$vacancy->post?>
                        </option>
                    <?php endforeach ?>
                </select>
                <input name="resume_id" type="hidden" value="<?= Yii::$app->request->get('id') ?>">
                <textarea class="jsMessage" name="message" rows="5" placeholder="Введите сообщение" required></textarea>
                <button class="jsBtnReg jsBtn" type="submit">Отправить</button>
                <?= Html::endForm() ?>
            </div>
        <?php endif ?>
        <?php if (!Yii::$app->user->isGuest):
            $resumes = \common\models\Resume::find()->where(['owner'=> Yii::$app->user->id, 'status'=>\common\models\Resume::STATUS_ACTIVE])->all()?>
        <div class="modal-style modal-send-message jsModalMessageVacancy">
            <h2>Написать нам
            </h2>
            <?= Html::beginForm(['/vacancy/default/send-message'], 'post', ['class' => 'jsModalRegForm']) ?>
                <select name="resume_id" class="jsModalSelectVacancy">
                    <?php foreach($resumes as $resume): ?>
                    <option value="<?=$resume->id?>">
                        <?=$resume->title?>
                    </option>
                    <?php endforeach ?>
                </select>
                <input name="vacancy_id" type="hidden" value="">
                <textarea class="jsMessage" name="message" rows="5" placeholder="Введите сообщение"></textarea>
                <button class="jsBtnReg jsBtn" type="submit">Отправить
                </button>
            <?= Html::endForm() ?>
        </div>
        <?php endif ?>
    </div>
</div>