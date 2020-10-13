<?php
/* @var $login_form \dektrium\user\models\LoginForm */

/* @var $registration_form RegUserForm */

use common\models\Resume;
use common\models\Vacancy;
use dektrium\user\widgets\Connect;
use frontend\models\user\RegUserForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<input type="hidden" id="jsInitialTab" value="<?=Yii::$app->request->get('tab')?>">
<div class="modal-block jsModal">
    <div class="modal-overlay jsModalClose">
    </div>
    <div class="modal-position">
        <div class="modal-close jsModalClose"><span></span><span></span>
        </div>
        <div class="modal-style modal-login jsModalLogin">
            <p>Вход
            </p>
            <?php

            $form = ActiveForm::begin([
                'action' => '/user/login',
                'id' => 'login-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
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
            <?= Connect::widget([
                'baseAuthUrl' => ['/user/security/auth']
            ]) ?>
            <?php ActiveForm::end(); ?>
            <div class="modal-style__text">
                <button class="jsForgotPass">Забыли пароль?</button>
                <button class="jsRegForm">Зарегистрироваться
                </button>
            </div>
        </div>
        <div class="modal-style modal-error jsForgotPassModal">
            <p>Восстановление пароля</p>
            <form method="post" action="/reset-password/send-token" id="reset_token_form">
                <input type="email" placeholder="Ваш Email" name="email">
                <button>Отправить</button>
            </form>
            <div class="modal-style__text">
                <button class="jsBackLogin">Авторизация</button>
            </div>
        </div>
        <div class="modal-style modal-reg jsModalReg">
            <p>Регистрация </p>
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'action' => '/registration/register',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'class' => 'jsModalRegForm',
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
            <?= $form->field($registration_form, 'status')->radioList( [10 => 'Соискатель', 20 => 'Работодатель',  21 => 'Частное лицо'])->label('Выберите тип аккаунта (после регистраации его нельзя будет изменить):');?>
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'jsBtnReg jsBtn']) ?>
            <?php ActiveForm::end(); ?>
            <div class="modal-style__text"><span>Есть учетная запись?</span>
                <button class="jsLoginForm">Войти</button>
            </div>
        </div>
        <div class="modal-style modal-error jsModalError">
            <p>Ошибка ввода </p>
            <div class="modal-style__circle">
                <div class="modal-style__circle__center"><img src="/images/checked.svg" alt="" role="presentation"/>
                </div>
            </div>
            <span class="modal-style__error-text">Вы ввели не верные данные вернитесь и заполните форму верное</span>
        </div>
        <?php if (!Yii::$app->user->isGuest):?>
            <?php /** @var Vacancy[] $vacancies */
            $vacancies = Vacancy::find()
                ->select(['id', 'post'])
                ->where(['owner'=> Yii::$app->user->id, 'status'=>Vacancy::STATUS_ACTIVE])
                ->andWhere(['>', Vacancy::tableName().'.active_until', time()])
                ->all()?>
            <div class="modal-style modal-send-message jsModalMessage">
                <?php if($vacancies):?>
                <p>Сообщение</p>
                <?= Html::beginForm(['/resume/default/send-message'], 'post', ['class' => 'jsModalMessageForm']) ?>
                <span>Выберите вакансию</span>
                <select name="resume_vacancy_id" class="jsModalSelectResume">
                    <?php foreach($vacancies as $vacancy): ?>
                        <option value="<?=$vacancy->id?>">
                            <?=$vacancy->post?>
                        </option>
                    <?php endforeach ?>
                </select>
                <input name="resume_resume_id" type="hidden" value="">
                <textarea class="jsMessage" name="resume_message" rows="5" placeholder="Введите сообщение" required></textarea>
                <button class="jsBtnReg jsBtn" type="submit">Отправить</button>
                <?= Html::endForm() ?>
            <?php else:?>
                <p class="modal-h2">Чтобы откликнуться на резюме <br><a href="/personal-area/add-vacancy">создайте вакансию</a>
                </p>
            <?php endif?>
            </div>
        <?php endif?>
        <?php
        /** @var Resume[] $resumes
         */
        $resumes = null;
        if (!Yii::$app->user->isGuest)
            $resumes = Resume::find()->select(['id', 'title'])->where(['owner'=> Yii::$app->user->id, 'status'=>Resume::STATUS_ACTIVE])->all()?>
        <div class="modal-style modal-send-message jsModalMessageVacancy">
            <?php if($resumes):?>
            <p>Написать нам
            </p>
            <?= Html::beginForm(['/vacancy/default/send-message'], 'post', ['class' => 'jsModalRegForm']) ?>
            <span>Выберите резюме</span>
                <select required name="vacancy_resume_id" class="jsModalSelectVacancy">
                    <?php foreach($resumes as $resume): ?>
                    <option value="<?=$resume->id?>">
                        <?=$resume->title?>
                    </option>
                    <?php endforeach ?>
                </select>
                <input name="vacancy_vacancy_id" type="hidden" value="">
                <textarea class="jsMessage" name="vacancy_message" rows="5" placeholder="Введите сообщение"></textarea>
                <button class="jsBtnReg jsBtn" type="submit">Отправить
                </button>
            <?= Html::endForm() ?>
            <?php else:?>
                <p class="modal-h2">Чтобы откликнуться на вакансию <br><a href="/personal-area/add-resume">создайте резюме</a>
                </p>
            <?php endif?>
        </div>
        <div class="modal-style modal-send-message jsModalMessageCompany">
            <?php if($resumes):?>
                <p>Написать нам</p>
                <?= Html::beginForm(['/company/default/send-message'], 'post', ['class' => 'jsModalRegForm']) ?>
                <span>Выберите резюме</span>
                <select required name="company_resume_id" class="jsModalSelectVacancy">
                    <?php foreach($resumes as $resume): ?>
                        <option value="<?=$resume->id?>">
                            <?=$resume->title?>
                        </option>
                    <?php endforeach ?>
                </select>
                <input name="company_company_id" type="hidden" value="">
                <textarea class="jsMessage" name="company_message" rows="5" placeholder="Введите сообщение"></textarea>
                <button class="jsBtnReg jsBtn" type="submit">Отправить
                </button>
                <?= Html::endForm() ?>
            <?php else:?>
                <p class="modal-h2">Чтобы откликнуться на вакансию <br><a href="/personal-area/add-resume">создайте резюме</a>
                </p>
            <?php endif?>
        </div>
        <div class="modal-style modal-success jsModalSuccess <?=Yii::$app->request->get('message')?'jsActive':''?>">
            <p><?= Yii::$app->request->get('message')?>
            </p>
        </div>
        <?php if(Yii::$app->request->get('message')==='Ваш аккаунт был успешно активирован'):?>
            <script>
                $(document).ready(function () {
                    gtag('event', 'registerVerify', { 'event_category': 'form', 'event_action': 'registerVerify', }); yaCounter53666866.reachGoal('registerVerify');
                });
            </script>
        <?php endif;?>
        <?php if(Yii::$app->request->get('message')==='Ваш аккаунт успешно зарегистрирован, проверьте почту для получения дальнейших инструкций'):?>
            <script>
                $(document).ready(function () {
                    VK.Retargeting.Init('VK-RTRG-443042-1VhMa');
                    VK.Retargeting.Event('Registration');
                });
            </script>
        <?php endif;?>

    </div>
</div>