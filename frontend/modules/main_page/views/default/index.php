<?php

/* @var $this View */
/* @var $categories Category[] */
/* @var $professions Professions[] */
/* @var $vacancies Vacancy[] */
/* @var $cities City[] */
/* @var $countries Country[] */
/* @var $vacancy_count integer */
/* @var $current_country Country|false */

/* @var $employer Employer */


use common\models\Category;
use common\models\City;
use common\models\Country;
use common\models\Employer;
use common\models\Professions;
use common\models\Resume;
use common\models\Vacancy;
use frontend\modules\main_page\classes\MetaFormer;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;

MetaFormer::registerMainPageTags($this, $current_country);
$background_image = $current_country?('..'.$current_country->main_page_background_image):'../images/new-home-bg.jpeg';
?>

<div class="nhome">
    <div class="nhome__main">
        <div class="nhome__main-top" style="background: linear-gradient( rgba(36, 60, 156, 0.78),rgba(36, 60, 156, 0.78) ),url(<?=$background_image?>) no-repeat; background-size: cover; background-position-x: center;">
            <div class="nhome__main-header">
                <button class="mobile-nav-btn jsOpenNavMenu"><img src="/images/menu.png" alt="" role="presentation"/>
                </button>
                <div class="filter-overlay nav-overlay jsNavOverlay">
                </div>
                <nav class="nhome__nav jsNavMenu">
                    <a class="nhome__nav-item nhome__nav-item_logo" href="<?=$current_country?"/$current_country->slug":"/"?>">
                        <img src="/images/logo-main.png" alt="Логотип rabota.today" role="presentation"/>
                        <img src="/images/logo-main-small.png" alt="Логотип rabota.today" role="presentation"/>
                        <img src="/images/logo_mob.png" alt="Логотип rabota.today" role="presentation"/>
                    </a>
                    <a class="nhome__nav-item" href="/employer">Работодателю</a>
                    <div class="geolocation">
                        <img src="/images/geolocation.png" alt="Геолокация">
                        <select class="city-header jsCountryHeaderSelect">
                            <option></option>
                            <?php foreach ($countries as $country):?>
                                <option <?= (Yii::$app->request->cookies['country'] == (string)$country->id) ? "selected" : '' ?>
                                        value="<?= $country->id ?>"><?= $country->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <a class="nhome__nav-item" href="<?= Resume::getSearchPageUrl() ?>">Поиск резюме</a>
                    <a class="nhome__nav-item" href="<?= Vacancy::getSearchPageUrl() ?>">Поиск вакансий</a>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <button class="nhome__nav-item nav-btn jsLogin">
                            Вход
                        </button>
                    <?php else: ?>
                        <div class="dropdown jsMenu">
                        <span class="nhome__nav-item nav-btn jsOpenMenu">
                            <?php if (!$employer->first_name && !$employer->second_name): ?>
                                <?= explode('@', Yii::$app->user->identity->email)[0] ?>
                            <?php else: ?>
                                <?= $employer->first_name . ' ' . $employer->second_name ?>
                            <?php endif ?>
                            <img src="/images/down-arrow.svg" alt="Стреклка вниз" role="presentation"/>
                            <span>></span>
                        </span>
                            <div class="dropdown__menu jsShowMenu">
                                <span class="nhome__nav-item mobile-prev jsMenuPrev">Назад</span>
                                <?php $messages = Yii::$app->user->identity->unreadMessages ?>
                                <a class="nhome__nav-item" href="<?= Url::to(['/personal_area/default/index']) ?>">Личный
                                    кабинет</a>
                                <a class="nhome__nav-item" href="<?= Url::to(['/personal-area/my-message']) ?>">Сообщения <?= $messages > 0 ? "($messages)" : "" ?></a>
                                <a class="nhome__nav-item" href="/personal-area/add-vacancy">Добавить вакансию</a>
                                <a class="nhome__nav-item" href="/personal-area/add-resume">Добавить резюме</a>
                                <?= Html::beginForm(['/user/security/logout'], 'post', ['class' => 'form-logout']) ?>
                                <?= Html::submitButton(
                                    'Выйти',
                                    ['class' => 'nhome__nav-item']
                                ) ?>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    <?php endif ?>
                </nav>
            </div>
            <div class="nhome__main-content">
                <div class="nhome__main-content-search">
                    <?= Html::beginForm([Vacancy::getSearchPageUrl()], 'get', ['class' => 'nhome__form']) ?>
                    <span class="nhome__form-text">
                            Сейчас на сайте свыше
                            <a href="<?= Vacancy::getSearchPageUrl() ?>"
                               class='white-text'> <?= $vacancy_count ?> вакансий </a>
                        </span>
                    <input name="search_text" class="nhome__form-input" placeholder="Я ищу..." type="text"/>
                    <?= Html::submitButton(
                        '<i class="fa fa-search"></i>',
                        ['class' => 'nhome__search btn-red']
                    ) ?>
                    <?= Html::endForm() ?>
                    <a class="btn btn-red mr20" href="<?= Resume::getSearchPageUrl() ?>">резюме</a>
                    <a class="btn btn-red" href="<?= Vacancy::getSearchPageUrl() ?>">вакансии</a>
                </div>
                <div class="geolocation">
                    <div class="geolocation__block">
                        <img src="/images/geolocation.png" alt="Геолокация">
                        <select class="city-header jsCityHeaderSelect">
                            <option></option>
                            <?php /** @var \common\models\City $city */
                            foreach ($countries as $country):?>
                                <option <?= (Yii::$app->request->cookies['country'] == (string)$country->id) ? "selected" : '' ?>
                                        value="<?= $country->id ?>"><?= $country->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <span class="nhome__form-text">
                        Сейчас на сайте свыше
                        <a href="<?= Vacancy::getSearchPageUrl() ?>" class='white-text'> <?= $vacancy_count ?> вакансий </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="nhome__main-bottom">
            <img class="nhome__main-big-circle" src="/images/home-big-circle.png" alt="Круг" role="presentation"/>
            <?php if($current_country):?>
                <img class="nhome__main-gerb" src="<?=$current_country->main_page_emblem?>" role="presentation"/>
            <?php else:?>
                <img class="nhome__main-gerb" src="/images/gerb-doneck-z1.png" alt="Герб Донецка" role="presentation"/>
            <?php endif ?>
            <h1 class="<?=$current_country?'nhome__custom-title':'nhome__title'?>"><?=$current_country?$current_country->meta_header:"Работа"?></h1>
            <div class="nhome__desc desc-pc">
                <?php if ($current_country):?>
                    <?=$current_country->main_page_text?>
                <?php else:?>
                Сайт поиска работы №1 в ДНР и ЛНР. Выбирайте из <a class="yellow-text"
                                                                   href="<?= Vacancy::getSearchPageUrl() ?>">2000+
                    вакансий</a> и 500+ компаний ДНР и ЛНР!<br>
                <a class="yellow-text" href="/personal-area/add-resume">Разместите резюме</a> и получите приглашения на
                работу от лучших работодателей.<br>
                Размещение вакансий и резюме - бесплатно.
                Размести сегодня - улучши качество жизни завтра!<br>
                Поиск работы в ДНР и ЛНР - это <a class="yellow-text" href="/">rabota.today.</a>
                <?php endif ?>
            </div>
            <!--googleoff: all-->
            <!--noindex-->
            <div class="nhome__desc desc-mob">
                <?php if ($current_country):?>
                    <?=$current_country->main_page_mobile_text?>
                <?php else:?>
                Сайт поиска работы №1 в ДНР и ЛНР. Выбирайте из 2000+ вакансий и 500+ компаний ДНР и ЛНР!<br>
                <a class="yellow-text" href="/">Поиск работы в ДНР и ЛНР - это rabota.today.</a>
                <?php endif ?>
            </div>
            <!--googleoff: all-->
            <!--noindex-->
            <img class="nhome__main-bottom-img" src="/images/img1.png" alt="Офисный стул" role="presentation"/>
        </div>
    </div>
    <aside class="nhome__aside">
        <img class="nhome__dots2" src="/images/bg-dots.png" alt="точки" role="presentation"/>
        <div class="nhome__aside-header">
            <h3 class="nhome__aside-header-vacancy">Вакансии дня</h3>
        </div>
        <div class="home__slider">
            <?php foreach ($vacancies as $vacancy): ?>
                <div class="single-card home-card">
                    <div class="single-card__tr">
                    </div>
                    <div class="single-card__header">
                        <img src="<?= $vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory) ?>" alt="Логотип <?=$vacancy->company->name?>" role="presentation"/>
                        <div class="single-card__top">
                            <div class="single-card__cat-city">
                                <?php if ($vacancy->mainCategory->name!='Пустая категория'): ?>
                                    <a class="btn-card btn-card-small btn-gray"
                                       href="<?= Url::to(["/vacancy/".$vacancy->mainCategory->slug]) ?>"
                                    ><?= $vacancy->mainCategory->name ?></a>
                                <?php endif ?>
                                <?php if ($city = $vacancy->city0): ?>
                                    <a class="d-flex align-items-center home-city"
                                       href="<?= Url::to(["/vacancy/$city->slug"]) ?>">
                                        <img class="single-card__icon" src="/images/arr-place.png" alt="Стрелка"
                                             role="presentation"/>
                                        <span class="ml5"><?= $city->name ?></span>
                                    </a>
                                <?php endif ?>
                            </div>
                            <a href="<?= Url::to(['/vacancy/default/view', 'id' => $vacancy->id]) ?>"
                               class="single-card__title"
                               title="<?= mb_convert_case($vacancy->post, MB_CASE_TITLE) ?>"><?= ucfirst($vacancy->post) ?></a>
                            <div class="single-card__info-second"><span
                                        class="mr10">Добавлено: <?= Yii::$app->formatter->asTime($vacancy->created_at, 'dd.MM.yyyy, hh:mm') ?></span>
                                <div class="single-card__view">
                                    <img class="single-card__icon mr5" src="/images/icon-eye.png" alt="иконка глаз" role="presentation"/>
                                    <span><?= count($vacancy->views0) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-card__info">
                        <?php if ($vacancy->employment_type): ?>
                            <p><?= $vacancy->employment_type->name ?>.</p>
                        <?php endif ?>
                        <p><?= StringHelper::truncate($vacancy->responsibilities, 80, '...') ?></p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-start">
                        <a class="btn-card btn-red jsVacancyModal" data-id="<?= $vacancy->id ?>">Откликнуться</a>
                        <!--                    <a class="single-card__like" href="#">-->
                        <!--                        <i class="fa fa-heart-o"></i>-->
                        <!--                        <span>В избранное</span>-->
                        <!--                    </a>-->
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </aside>
    <div class="nhome__footer">
        <div class="nhome__footer-left">
            <a class="footer__craft-link" href="https://web-artcraft.com/" target="_blank">
                Разработано CraftGroup
            </a>
            <a class="nhome__footer-left-soc" rel="nofollow" target="_blank" href="https://vk.com/rabotad0netsk">
                <img class="vk-bg" src="/images/vk.svg" alt="Иконка VK" role="presentation">Есть вопросы?<br>
                Напиши нам в соц.сетях
            </a>
            <span>
                © 2019–2020 <a href="/">Rabota.today</a>.<br>
                Сайт поиска работы №1<br>
                в ДНР и ЛНР
            </span>
        </div>
        <div class="nhome__footer-item">
            <div class="nhome__footer-item-head">
                <img src="/images/index_city.png" alt="Города">
                <p>Вакансии<br> по городам <span>1000+</span></p>
            </div>
            <?php
            $i = 0;
            foreach ($cities as $city):?>
                <?php if ($i < 4): ?>
                    <a href="<?= Vacancy::getSearchPageUrl(false, $city->slug) ?>"><?= $city->name ?></a>
                <?php
                endif;
                $i++;
            endforeach; ?>
            <a href="<?=Url::toRoute(['/main_page/default/city'])?>">все города</a>
        </div>
        <div class="nhome__footer-item">
            <div class="nhome__footer-item-head">
                <img src="/images/index_vacancy.png" alt="Города">
                <p>Вакансии<br> по категориям <span>300+</span></p>
            </div>
            <?php foreach ($categories as $category):?>
                <a href="<?= Vacancy::getSearchPageUrl($category->slug) ?>"><?= $category->name ?></a>
            <?php endforeach; ?>
            <a href="<?= Vacancy::getSearchPageUrl() ?>">все вакансии</a>
        </div>
        <div class="nhome__footer-item">
            <div class="nhome__footer-item-head">
                <img src="/images/index_prof.png" alt="Города">
                <p>Вакансии<br> по профессиям <span>500+</span></p>
            </div>
            <?php foreach ($professions as $profession):?>
                <a href="<?= Vacancy::getSearchPageUrl(false, false, $profession->slug) ?>"><?= $profession->title ?></a>
            <?php endforeach; ?>
            <?php if($current_country):?>
                <a href="<?=Url::toRoute(["/$current_country->slug/professions"])?>">все профессии</a>
            <?php else:?>
                <a href="<?=Url::toRoute(['/main_page/default/professions'])?>">все профессии</a>
            <?php endif ?>
        </div>
    </div>
    <div class="nhome__circle"></div>
</div>
