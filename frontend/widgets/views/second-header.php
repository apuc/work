<?php
/* @var $employer \common\models\Employer */
/* @var $countries \common\models\Country[] */
/* @var $this \yii\web\View */

use common\models\City;
use common\models\Resume;
use common\models\Vacancy;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<header class="header-wrap jsHeaderIndex">
    <img class="header-wrap__bg"
         src="<?=!empty(Yii::$app->controller->background_image)?Yii::$app->controller->background_image:'/images/bg_header_vacancies.jpeg'?>"
         alt="Фоновое изображение"
    >
    <img class="header-wrap__emblem"
         src="<?=!empty(Yii::$app->controller->background_emblem)?Yii::$app->controller->background_emblem:'/images/img2.png'?>"
         alt="Фоновая эмблема"
         role="presentation"
    />
    <div class="container">
        <div class="header">
            <div class="home__main-top">
                <div class="home__main-header">
                    <button class="mobile-nav-btn jsOpenNavMenu">
                        <img src="/images/menu.png" alt="Мобильное меню" role="presentation"/>
                    </button>
                    <div class="filter-overlay nav-overlay jsNavOverlay">
                    </div>
                    <nav class="home__nav jsNavMenu">
                        <a class="home__nav-item home__nav-item_logo" href="<?=Yii::$app->request->cookies['country_id']?"/".Yii::$app->request->cookies['country_slug']:"/"?>">
                            <img src="/images/logo-main.png" alt="Логотип rabota.today" role="presentation"/>
                            <img src="/images/logo_mob.png" alt="Логотип rabota.today" role="presentation"/>
                        </a>
                        <a class="home__nav-item" href="/employer">Работодателю</a>
                        <div class="geolocation">
                            <img src="/images/geolocation.png" alt="Геолокация">
                            <select class="city-header jsCountryHeaderSelect">
                                <option></option>
                                <?php foreach ($countries as $country):?>
                                    <option <?= (Yii::$app->request->cookies['country_id'] == (string)$country->id) ? "selected" : '' ?>
                                            value="<?= $country->id ?>"><?= $country->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if(Yii::$app->controller->uniqueId === "vacancy/default"):?>
                            <a class="home__nav-item border-top-header" href="<?= Vacancy::getSearchPageUrl() ?>">Вакансии</a>
                        <?php else:?>
                            <a class="home__nav-item border-top-header"" href="<?= Resume::getSearchPageUrl() ?>">Резюме</a>
                        <?php endif?>
                        <?php
                        if (Yii::$app->user->isGuest): ?>
                            <button class="home__nav-item jsLogin">
                                Вход
                            </button>
                        <?php else: ?>
                            <div class="dropdown jsMenu">
                                <span class="home__nav-item jsOpenMenu">
                                    <?php if (!$employer->first_name && !$employer->second_name): ?>
                                        <?= explode('@', Yii::$app->user->identity->email)[0] ?>
                                    <?php else: ?>
                                        <?= $employer->first_name . ' ' . $employer->second_name ?>
                                    <?php endif ?>
                                    <img src="/images/down-arrow.svg" alt="Стрелка" role="presentation"/>
                                    <span>></span>
                                </span>
                                <?php $messages=Yii::$app->user->identity->unreadMessages ?>
                                <div class="dropdown__menu jsShowMenu">
                                    <span class="nhome__nav-item mobile-prev jsMenuPrev">Назад</span>
                                    <a class="home__nav-item" href="/personal-area">Личный кабинет</a>
                                    <a class="home__nav-item" href="<?=Url::to(['/personal-area/my-message'])?>">Сообщения <?=$messages>0?"($messages)":""?></a>
                                    <a class="home__nav-item" href="/personal-area/add-vacancy">Добавить вакансию</a>
                                    <a class="home__nav-item" href="/personal-area/add-resume">Добавить резюме</a>
                                    <?= Html::beginForm(['/user/security/logout'], 'post', ['class' => 'form-logout']) ?>
                                    <?= Html::submitButton(
                                        'Выйти',
                                        ['class' => 'home__nav-item btn-logout']
                                    ) ?>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                        <?php endif ?>

                    </nav>
                    <div class="home__main-email align-items-center"><span class="home__main-ico">@</span><a
                                href="mailto:info@rabota.today">info@rabota.today</a>
                    </div>
                    <a class="home__mobile-logo" href="/">
                        <img src="/images/logo-main.png" alt="Логотип rabota.today" role="presentation"/>
                    </a>
                </div>
                <div class="home__main-content">
                    <?= Html::beginForm([Vacancy::getSearchPageUrl()], 'get', ['class' => 'home__form']) ?>
                    <input name="search_text" class="home__form-input" placeholder="Я ищу..." type="text"/>
                    <?= Html::submitButton(
                        '<i class="fa fa-search"></i>',
                        ['class' => 'home__search btn-red']
                    ) ?>
                    <?= Html::endForm() ?>
                    <a class="btn btn-red mr20" href="/personal-area/add-resume">разместить резюме</a>
                    <a class="btn btn-red" href="/personal-area/add-vacancy">создать вакансию</a>
                </div>
            </div>
        </div>
    </div>
</header>