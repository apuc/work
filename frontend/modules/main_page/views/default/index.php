<?php

/* @var $this \yii\web\View */
/* @var $categories \common\models\Category[] */
/* @var $vacancies \common\models\Vacancy[] */


use dektrium\user\models\RegistrationForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="root">
    <section class="home">
        <div class="home__aside">
            <div class="home__aside-header">
                <div class="logo">
                    <div class="logo__img"><img class="logo__main" src="images/logo.png" alt=""
                                                role="presentation"/><img class="logo__info" src="images/ico-i.png"
                                                                          alt="" role="presentation"/>
                    </div>
                    <span class="logo__text">Актуальных вакансий сейчас</span>
                </div>
                <span class="home__aside-header-vacancy">Вакансии дня</span>
            </div>
            <div class="home__slider">
                <?php foreach ($vacancies as $vacancy):?>
                    <div class="single-card">
                        <div class="single-card__tr">
                        </div>
                        <div>
                            <a class="btn-card btn-card-small btn-gray" href="#">
                                <?php foreach ($vacancy->category as $category):?>
                                    <?=$category->name?>
                                <?php endforeach;?>
                            </a>
                        </div>
                        <h3 class="single-card__title mt5 mb0"><?=$vacancy->post?></h3>
                        <div class="single-card__info-second">
                            <span class="mr10">Добавлено: <?= Yii::$app->formatter->asTime($vacancy->created_at, 'dd MM yyyy, hh:mm')?></span>
                            <div class="single-card__view">
                                <img class="single-card__icon mr5" src="images/icon-eye.png" alt="" role="presentation"/>
                                <span>255</span>
                            </div>
                            <a class="d-flex align-items-center ml-auto mt5 mb5" href="#">
                                <img class="single-card__icon" src="images/arr-place.png" alt="" role="presentation"/>
                                <span class="ml5"><?=$vacancy->city?></span>
                            </a>
                        </div>
                        <div class="single-card__info">
                            <p><?=$vacancy->responsibilities?></p>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-end mt-auto">
                            <a class="single-card__like mt5 mb5" href="#">
                                <i class="fa fa-heart-o"></i>
                                <span>В избранное</span>
                            </a>
                            <a class="btn-card btn-red mt5 mb5 ml15">Посмотреть полностью</a>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="home__main">
            <div class="white-line">
                <div class="white-line__square">
                </div>
            </div>
            <div class="white-line">
                <div class="white-line__square">
                </div>
                <div class="white-line__square">
                </div>
            </div>
            <div class="white-line">
                <div class="white-line__square">
                </div>
            </div>
            <div class="white-line">
                <div class="white-line__square">
                </div>
            </div>
            <div class="white-line">
                <div class="white-line__square">
                </div>
                <div class="white-line__square">
                </div>
            </div>
            <div class="home__main-top">
                <div class="home__main-header">
                    <nav class="home__nav"><a class="home__nav-item" href="/">Главная</a><a class="home__nav-item"
                                                                                            href="resume.html">Резюме</a>
                        <button class="home__nav-item jsLogin">
                            <?php if (Yii::$app->user->isGuest): ?>
                                Вход
                            <?php else: ?>
                                <?= Yii::$app->user->identity->username ?>
                            <?php endif ?>
                        </button>
                        <?= Html::beginForm(['/site/logout'], 'post') ?>
                        <?= Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout']
                        ) ?>
                        <?= Html::endForm() ?>
                    </nav>
                    <div class="home__main-email d-flex align-items-center"><span class="home__main-ico">@</span><a
                                href="mailto:info@vendoram.ru">info@vendoram.ru</a>
                    </div>
                    <div class="d-flex align-items-center"><i class="home__main-ico fa fa-phone"></i>
                        <div class="d-flex flex-column"><a href="tel:88003553505">+8 800 355-35-05</a><a
                                    class="home__callback" href="#">Заказать обратный звонок</a>
                        </div>
                    </div>
                </div>
                <div class="home__main-content">
                    <form class="home__form"><input class="home__form-input" placeholder="Я ищу..." type="text"/>
                        <div class="home__form-select">
                            <select class="home__form-select-js">
                                <option></option>
                                <option>Пункт 1</option>
                                <option>Пункт 2</option>
                                <option>Пункт 3</option>
                            </select>
                        </div>
                        <button class="home__search btn-red" type="submit"><i class="fa fa-search"></i>
                        </button>
                    </form>
                    <a class="btn btn-red mr20" href="#">разместить резюме</a><a class="btn btn-red"
                                                                                 href="all-vacancies.html">Найти
                        вакансии</a>
                </div>
            </div>
            <div class="home__main-bottom">
                <div class="home__main-circle">
                </div>
                <h1 class="home__title">Работа
                </h1>
                <p class="home__desc">Сделайте грамотный выбор! Предлагаем размещение и продвижение на новой и
                    перспективной площадке <span class="c-red">РаботаДНР</span>. Станьте первым и получайте максимум
                    продаж, опережая конкурентов на несколько шагов. Полностью берем на себя все, что связано с
                    размещением на маркетплейсе, эффективно управляем ценами и поставками
                </p><img class="home__main-bottom-img" src="images/img1.png" img="" alt="" role="presentation"/>
            </div>
        </div>
        <div class="home__footer">
            <?php foreach($categories as $category): ?>
                <a class="home__footer-item" href="#"><?=$category->name?> <?=$category->vacancy_count?></a>
            <?php endforeach ?>
        </div>
        <img class="home__dots1" src="images/bg-dots.png" alt="" role="presentation"/><img class="home__dots2"
                                                                                           src="images/bg-dots.png"
                                                                                           alt=""
                                                                                           role="presentation"/><img
                class="home__emblem" src="images/img2.png" alt="" role="presentation"/>
        <div class="home__circle">
        </div>
    </section>
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
                ]) ?>
                <!--                <form class="jsModalLoginForm">-->
                <?= $form->field($model, 'login',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'jsMail', 'tabindex' => '1', 'placeholder' => 'Электронная почта']]
                )->label(false);
                ?>
                <?= $form->field(
                    $model,
                    'password',
                    ['inputOptions' => ['class' => 'jsPass', 'tabindex' => '2', 'placeholder' => 'Пароль']])
                    ->passwordInput()->label(false);
                ?>
                <!--                    <input class="jsMail" type="email" name="email" placeholder="Электронная почта"/>-->
                <!--                    <input class="jsPass" type="password" name="pass" placeholder="Пароль"/>-->
                <?= Html::submitButton(
                    Yii::t('user', 'Войти'),
                    ['class' => 'jsBtnLogin jsBtn', 'tabindex' => '4']
                ) ?>
                <!--                    <button class="jsBtnLogin jsBtn" type="submit" disabled="disabled">Войти-->
                <!--                    </button>-->
                <!--                </form>-->
                <?php ActiveForm::end(); ?>
                <div class="modal-style__text"><span>Забыли пароль?</span>
                    <button class="jsRegForm">Зарегистрироваться
                    </button>
                </div>
            </div>
            <div class="modal-style modal-reg jsModalReg">
                <h2>Регистрация
                </h2>
                <?php
                /** @var RegistrationForm $model */
                $model = \Yii::createObject(RegistrationForm::className());
                $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'action' => '/registration/register',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'class' => 'jsModalRegForm'
                ]); ?>
                <input class="jsName" type="text" name="first_name" placeholder="Имя"/>
                <input class="jsSurname" type="text" name="second_name" placeholder="Фамилия"/>
                <input type="hidden" name="register-form[username]" value=""/>
                <?= $form->field($model, 'email', ['inputOptions' => ['class' => 'jsMail', 'placeholder' => 'Электронная почта']])->label(false) ?>
                <?= $form->field(
                    $model,
                    'password',
                    ['inputOptions' => ['class' => 'jsPass', 'placeholder' => 'Пароль']])
                    ->passwordInput()->label(false);
                ?>
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'jsBtnReg jsBtn']) ?>
                <?php ActiveForm::end(); ?>
                <div class="modal-style__text"><span>Есть учетная запись?</span>
                    <button class="jsLoginForm">Войти
                    </button>
                </div>
            </div>
            <div class="modal-style modal-error jsModalError">
                <h2>Ошибка ввода
                </h2>
                <div class="modal-style__circle">
                    <div class="modal-style__circle__center"><img src="images/checked.svg" alt="" role="presentation"/>
                    </div>
                </div>
                <span class="modal-style__error-text">Вы ввели не верные данные вернитесь и заполните форму верное</span>
            </div>
        </div>
    </div>
</div>