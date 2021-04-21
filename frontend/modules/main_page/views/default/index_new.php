<?php

/* @var $this View */
/* @var $categories Category[] */
/* @var $professions Professions[] */
/* @var $vacancies Vacancy[] */
/* @var $companies array */
/* @var $cities City[] */
/* @var $countries Country[] */
/* @var $vacancy_count integer */
/* @var $current_country Country|false */
/* @var $user \common\models\User */

/* @var $employer Employer */


use common\classes\MoneyFormat;
use common\helpers\RussianCaseHelper;
use common\models\Category;
use common\models\City;
use common\models\Company;
use common\models\Country;
use common\models\Employer;
use common\models\Professions;
use common\models\Vacancy;
use frontend\modules\main_page\classes\MetaFormer;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\View;

MetaFormer::registerMainPageTags($this, $current_country);
$background_image = $current_country?('..'.$current_country->main_page_background_image):'../images/new-home-bg.jpeg';
?>
<div class="container header">
    <header class="header-wrap">
        <div class="jsOpenNavMenu header-wrap__button_menu">
            <img class="jsMenuLogo " src="/images/main_page/grid.png" height="34" width="34"/>
            <img class="jsMenuLogoActive btn-active" src="/images/main_page/grid_active.png" height="34" width="34"/>
        </div>
        <div class="filter-overlay nav-overlay jsNavOverlay" style="display: block;"></div>
        <div class="jsNavMenu header-wrap__navParent">
            <nav class="nav-logo">
                <a class="" href="">
                    <img src="/images/main_page/logo-main_(2).jpg" alt="logo"></a>
                <a href="">Россия</a>
            </nav>
        </div>
        <nav class="navigation">
            <div class="button-cover">
                <div class="button b2" id="button-10">
                    <input id="toggleRole" type="checkbox" class="checkbox">
                    <div class="knobs">
                        <span>Соискатель</span>
                    </div>
                    <div class="layer"></div>
                </div>
            </div>
        </nav>








        <div class="jsNavMenu header-wrap__navParent">
            <nav class="nav-pa cmn-overlays-nav">
                <div class="clearfix">
                    <a class="link__"  href="#sign">Вход</a>
                    <a class="link__" href="#reg">Регистрация</a>
                    <a class="abstract" href="#resume">Добавить Резюме</a>
                </div>
            </nav>
        </div>


        <!-- Modal Content Sign-->

        <section class="section_modal" id="sign">
            <div class="content">
                <article>
                    <div class="modal-style modal-login jsModalLogin" style="display: block;">
                        <p>Вход
                        </p>
                        <form id="login-form" action="/user/login" method="post">
                            <input type="hidden" name="_csrf" value="al9gHk70gVwtWMKOGF5W9sn_GuTadS4t1yAhU3WAJHJeCAZsO4S5bkBsmttWHyWhooVos4kbGRulRUAGH-9ONA==">

                            <div class="form-group field-login-form-login required">

                                <input type="text" id="login-form-login" class="jsMail" name="login-form[login]" autofocus="autofocus" tabindex="1" placeholder="Электронная почта" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <div class="form-group field-login-form-password required">

                                <input type="password" id="login-form-password" class="jsPass" name="login-form[password]" tabindex="2" placeholder="Пароль" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <button type="submit" class="jsBtnLogin jsBtn" tabindex="4">Войти</button>            <div id="w0"><ul class="auth-clients"><li><a class="vkontakte auth-link" href="/user/auth?authclient=vkontakte" title="ВКонтакте"><span class="auth-icon vkontakte"></span></a></li></ul></div>            </form>            <div class="modal-style__text">









                            <nav class="nav-pa cmn-overlays-nav">
                                <div class="clearfix">
                                    <a href="#forgot" class="reg_link">Забыли пароль?</a>
                                    <a href="#reg" class="reg_link">Зарегистрироваться</a>
                                </div>
                            </nav>

                            <!-- <button><a href="">Зарегистрироваться</a></button> -->



                        </div>
                    </div>
                </article>
                <a href="#" class="close">x</a>
            </div><!-- /.content -->
        </section><!-- /section#html -->




        <!-- Modal Content Reg-->

        <section class="section_modal" id="forgot">
            <div class="content">
                <article>
                    <div class="modal-style modal-error jsForgotPassModal" style="display: block;">
                        <p>Восстановление пароля</p>
                        <form method="post" action="/reset-password/send-token" id="reset_token_form">
                            <input type="email" placeholder="Ваш Email" name="email">
                            <button>Отправить</button>
                        </form>
                        <div class="modal-style__text">
                            <nav class="nav-pa cmn-overlays-nav">
                                <div class="clearfix">
                                    <a href="#auth" class="reg_link">Авторизация</a>
                                </div>
                            </nav>

                        </div>
                    </div>
                </article>
                <a href="#" class="close">x</a>
            </div><!-- /.content -->
        </section><!-- /section#html -->



        <!-- Modal Content Auth-->

        <section class="section_modal" id="auth">
            <div class="content">
                <article>
                    <div class="modal-style modal-login jsModalLogin" style="display: block;">
                        <p>Вход
                        </p>
                        <form id="login-form" action="/user/login" method="post">
                            <input type="hidden" name="_csrf" value="al9gHk70gVwtWMKOGF5W9sn_GuTadS4t1yAhU3WAJHJeCAZsO4S5bkBsmttWHyWhooVos4kbGRulRUAGH-9ONA==">

                            <div class="form-group field-login-form-login required">

                                <input type="text" id="login-form-login" class="jsMail" name="login-form[login]" autofocus="autofocus" tabindex="1" placeholder="Электронная почта" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <div class="form-group field-login-form-password required">

                                <input type="password" id="login-form-password" class="jsPass" name="login-form[password]" tabindex="2" placeholder="Пароль" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <button type="submit" class="jsBtnLogin jsBtn" tabindex="4">Войти</button>            <div id="w0"><ul class="auth-clients"><li><a class="vkontakte auth-link" href="/user/auth?authclient=vkontakte" title="ВКонтакте"><span class="auth-icon vkontakte"></span></a></li></ul></div>            </form>            <div class="modal-style__text">



                        </div>
                    </div>
                </article>
                <a href="#" class="close">x</a>
            </div><!-- /.content -->
        </section><!-- /section#html -->






        <!-- Modal Content Reg-->

        <section class="section_modal" id="reg">
            <div class="content content-reg">
                <article>
                    <div class="modal-style modal-reg jsModalReg" style="display: block;">
                        <p>Регистрация </p>
                        <form id="registration-form" action="/registration/register" method="post">
                            <input type="hidden" name="_csrf" value="gzQUGI72U5TAJvECen_qhTz68mZJLHX_oXXSWxKNeZy3Y3Jq-4Zrpq0SqVc0PpnSV4CAMRpCQsnTELMOeOIT2g==">            <input class="jsName" type="text" name="first_name" placeholder="Имя">
                            <input class="jsSurname" type="text" name="second_name" placeholder="Фамилия">
                            <input type="hidden" name="register-form[username]" value="">
                            <div class="form-group field-register-form-email required">

                                <input type="text" id="register-form-email" class="jsMail" name="register-form[email]" placeholder="Электронная почта" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <div class="form-group field-register-form-password required">

                                <input type="password" id="register-form-password" class="jsPass" name="register-form[password]" placeholder="Пароль" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <div class="form-group field-register-form-status required">
                                <label class="control-label">Выберите тип аккаунта (после регистраации его нельзя будет изменить):</label>
                                <input type="hidden" name="register-form[status]" value=""><div id="register-form-status" role="radiogroup" aria-required="true"><label><input type="radio" name="register-form[status]" value="10"> Соискатель</label>
                                    <label><input type="radio" name="register-form[status]" value="20"> Работодатель</label>
                                    <label><input type="radio" name="register-form[status]" value="21"> Частное лицо</label></div>

                                <div class="help-block"></div>
                            </div>            <button type="submit" class="jsBtnReg jsBtn">Зарегистрироваться</button>            </form>            <div class="modal-style__text"><span>Есть учетная запись?</span>


                            <nav class="nav-pa cmn-overlays-nav">
                                <div class="clearfix">
                                    <a href="#empty" class="jsLoginForm reg_link">Войти</a>
                                </div>
                            </nav>




                        </div>
                    </div>
                </article>
                <a href="#" class="close">x</a>
            </div><!-- /.content -->
        </section><!-- /section#html -->




        <!-- Modal Content Empty-->

        <section class="section_modal" id="empty">
            <div class="content">
                <article>
                    <div class="modal-style modal-login jsModalLogin" style="display: block;">
                        <p>Вход
                        </p>
                        <form id="login-form" action="/user/login" method="post">
                            <input type="hidden" name="_csrf" value="al9gHk70gVwtWMKOGF5W9sn_GuTadS4t1yAhU3WAJHJeCAZsO4S5bkBsmttWHyWhooVos4kbGRulRUAGH-9ONA==">

                            <div class="form-group field-login-form-login required">

                                <input type="text" id="login-form-login" class="jsMail" name="login-form[login]" autofocus="autofocus" tabindex="1" placeholder="Электронная почта" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <div class="form-group field-login-form-password required">

                                <input type="password" id="login-form-password" class="jsPass" name="login-form[password]" tabindex="2" placeholder="Пароль" aria-required="true">

                                <div class="help-block"></div>
                            </div>            <button type="submit" class="jsBtnLogin jsBtn" tabindex="4">Войти</button>            <div id="w0"><ul class="auth-clients"><li><a class="vkontakte auth-link" href="/user/auth?authclient=vkontakte" title="ВКонтакте"><span class="auth-icon vkontakte"></span></a></li></ul></div>            </form>            <div class="modal-style__text">



                        </div>
                    </div>
                </article>
                <a href="#" class="close">x</a>
            </div><!-- /.content -->
        </section><!-- /section#html -->




        <!-- Modal Content Resume-->

        <section class="section_modal" id="resume">
            <div class="content content-resume">
                <article>
                    <div class="modal-style modal-send-message jsModalMessageVacancy" style="display: block;">
                        <p class="modal-h2">Чтобы откликнуться на вакансию <br><a href="/personal-area/add-resume" class="link__">создайте резюме</a>
                        </p>
                    </div>
                </article>
                <a href="#" class="close">x</a>
            </div><!-- /.content -->
        </section><!-- /section#html -->





    </header>
    <div class="background__pointer_right"><img src="/images/main_page/Фон_точки_.png" alt="bg"></div>
    <div class="background__pointer_left"><img src="/images/main_page/Фон_точки_.png" alt="bg"></div>
    <div class="search">
        <div class="search-p">Сайт поиска работы №1. Выбирайте из <a class="yellow-text"
                                                                     href="<?= Vacancy::getSearchPageUrl() ?>">2000+
                вакансий</a> и <span>500+</span>
            компаний!
        </div>
        <form class="formSearch">
            <label class="formSearch__select">
            <?=Select2::widget([
                'name' => 'state',
                'data' => [
                    'dnr' => 'ДНР',
                    'lnr' => 'ЛНР'
                ],
                'options' => [
                    'id' => 'select2City',
                    'class' => 'searchCity__select js-example-basic-single'
                ]
            ])?>
            </label>
            <div class="searchCity">
                <input class="searchCity__input searchVacancy" type="text" name="vacancyHeader"
                       placeholder="Должность или компания">
                <button class="searchCity__button_color"><img src="/images/main_page/search.svg" alt=""></button>
            </div>
            <a data-search="vacancy" class="border_before">НАЙТИ ВАКАНСИИ</a>
        </form>
        <div class="iconChair"><img src="/images/main_page/icon-chair_versiya1.png"></div>
    </div>
    <div class="background__after_search">
        <div class="svgRelative">
            <p><?=$current_country ? $current_country->meta_header : "Работа"?>
                <sup class="svgRelative__sup_position">
                    <svg id="SVGDoc" width="100" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1"
                         viewBox="0 0 76 77">
                        <defs>
                            <mask id="Mask1018" x="-1" y="-1" width="2" height="2">
                                <rect width="33" height="33" x="18" y="16" fill="#ffffff"></rect>
                                <path
                                        d="M34.28996,15.99994c8.99677,0 16.29009,7.29325 16.29009,16.29007c0,8.99671 -7.29332,16.28996 -16.29009,16.28996c-8.99666,0 -16.28998,-7.29325 -16.28998,-16.28996c0,-8.99682 7.29332,-16.29007 16.28998,-16.29007z"
                                        fill="#000000"></path>
                            </mask>
                            <filter id="Filter1022" width="110.5" height="113.1" x="-19" y="-21"
                                    filterUnits="userSpaceOnUse">
                                <feOffset dx="3.5" dy="6.1" result="FeOffset1023Out" in="SourceGraphic"></feOffset>
                                <feGaussianBlur stdDeviation="10.8 10.8" result="FeGaussianBlur1024Out"
                                                in="FeOffset1023Out"></feGaussianBlur>
                            </filter>
                        </defs>
                        <g>
                            <g><title>Эллипс 1 копия 5</title>
                                <g filter="url(#Filter1022)">
                                    <path
                                            d="M34.28996,15.99994c8.99677,0 16.29009,7.29325 16.29009,16.29007c0,8.99671 -7.29332,16.28996 -16.29009,16.28996c-8.99666,0 -16.28998,-7.29325 -16.28998,-16.28996c0,-8.99682 7.29332,-16.29007 16.28998,-16.29007z"
                                            fill="none" stroke-opacity="0.43" stroke-width="0"
                                            mask="url(&quot;#Mask1018&quot;)"></path>
                                    <path
                                            d="M34.28996,15.99994c8.99677,0 16.29009,7.29325 16.29009,16.29007c0,8.99671 -7.29332,16.28996 -16.29009,16.28996c-8.99666,0 -16.28998,-7.29325 -16.28998,-16.28996c0,-8.99682 7.29332,-16.29007 16.28998,-16.29007z"
                                            fill="#80375d" fill-opacity="0.43"></path>
                                </g>
                                <path
                                        d="M34.28996,15.99994c8.99677,0 16.29009,7.29325 16.29009,16.29007c0,8.99671 -7.29332,16.28996 -16.29009,16.28996c-8.99666,0 -16.28998,-7.29325 -16.28998,-16.28996c0,-8.99682 7.29332,-16.29007 16.28998,-16.29007z"
                                        fill="#df574f" fill-opacity="1"></path>
                            </g>
                        </g>
                    </svg>
                    +55 за сегодня</sup></p>
        </div>
    </div>
</div>
<div class="container">
    <section class="container__section">
        <div class="content-wrapper">
            <div class="content-wrapper__middle-content">
                <div class="slider__wrapp">
                    <p class="slider__city-description">Вакансии дня</p>

                    <div class="slider swiper-container">
                        <div class="slider__wrapper swiper-wrapper">
                            <?php foreach ($vacancies as $vacancy): ?>
                            <a class="home-kard swiper-slide">
                                <svg class="home-kard-treugol" width="15px"
                                     height="15px" viewBox="0 0 2 2" preserveAspectRatio="none">
                                    <polygon fill="#FFF" points="1,0 2,2 0,2"/>
                                </svg>
                                <img class="home-kard__img" src="<?= $vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory) ?>">

                                <div class="home-kard__info">

                                    <p class="home-kard__info_description"><?=$vacancy->post?></p><br>
                                    <span class="home-kard__info_salary">
                                        <?=$vacancy->getMoneyString()?>
                                        <?php if ($vacancy->hot == 1): ?>
                                        <span  class="home-kard_fire">
                                            <img class="home-kard_fire_img" src="images/main_page/cd-burn.svg" alt="">
                                            <p class="home-kard_fire_text">Горячая вакансия</p>
                                        </span>
                                        <?php endif; ?>
                                    </span>

                                    <p class="home-kard__info_company"><?=$vacancy->company->name?></p>
                                </div>
                            </a>
                            <?php endforeach; ?>

                            <a class="slider__control slider__control_left" href="#" role="button"></a>
                            <a class="slider__control slider__control_right" href="#" role="button"></a>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper__callOut">
                    <p class="content-wrapper__p">Сделайте грамотный выбор! Предлагаем размещение и продвижение на новой
                        и
                        перспективной площадке <a class="content-wrapper__p__a" href="/">Работа ДНР</a>. Станьте первым и
                        получайте
                        максимум продаж, опережая конкурентов на несколько шагов. Полностью берем на себя все, что
                        связано с
                        размещением на маркетплейсе, эффективно управляем ценами и поставками</p>
                    <p class="content-wrapper__callOut-p">450 000 компаний подбирают
                        сотрудников на Rabota.today</p>

                    <div class="block-company">
                        <?php /** @var Company $company */
                        foreach ($companies as $company): ?>
                        <a class="block-company__single-company">
                            <img class="block-company__single-company__image" src="https://i.pinimg.com/originals/d3/71/d1/d371d1231aafbc9703426615aaca3da8.jpg">
                            <p class="block-company__single-company_description">
                                <span class="block-company__single-company_description-color"><?=$company['vacancies_count']?> вакансий</span>
                                <span class="company__text">компании</span>
                            </p>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <div class="content-wrapper__search-job">
                <div class="content-wrapper__search-job__content-block-text">
                    <p class="content-wrapper__search-job__content-block-text-title">Поиск работы </p>
                    <p class="content-wrapper__search-job__content-block-text-p">Работа.ру — один из лидеров на
                        рынке
                        трудоустройства. С нами легко искать работу в Москве и
                        регионах.</p>
                    <p class="content-wrapper__search-job__content-block-text-p">
                        На нашем сайте вы можете бесплатно размещать резюме, искать вакансии, откликаться на них,
                        отправлять резюме на интересные
                        предложения, чатиться с работодателями.</p>
                    <div class="content-wrapper__search-job-content-inner">
                        <img class="content-wrapper__search-job-content-inner__img" src="/images/main_page/suitcase.jpg">
                        <div class="content-wrapper__search-job-content-inner__button"><p>Подписка на новые
                                вакансии</p>
                            <div class="content-wrapper__search-job-content-inner__button-parent"></div>
                            <button class="content-wrapper__search-job-content-inner__button-btn">Подписаться
                            </button>
                        </div>
                    </div>
                    <p class="content-wrapper__search-job__content-block-footer-text">Подписка позволяет <span>отслеживать  новые вакансии </span>по
                        соответствующим условиям на сайте иили получать
                        их по электронной почте</p>
                </div>
                <div class="content-wrapper__search-job__content-block-categories">
                    <div class="content-wrapper__search-job__content-block-categories__block">
                        <div class="content-wrapper__search-job-block">
                            <div class="content-wrapper__search-job__content-block-categories__icon-block">
                                <div
                                        class="content-wrapper__search-job__content-block-categories__icon-block__container-forImg">
                                    <img class="icon-img" src="/images/main_page/city_red.png"></div>
                                <div class="content-wrapper__search-job__content-block-categories__icon-block__container-forP">
                                    <p>Вакансии по городам</p><span>1000+</span></div>

                            </div>
                            <div class="content-wrapper__search-job__content-block-list">
                                <ul class="content-block-list">
                                    <?php foreach ($cities as $city): ?>
                                        <li class="content-list"><a href="<?= Vacancy::getSearchPageUrl(false, $city->slug) ?>"> <?= $city->name ?></a></li>
                                        <a href="<?= Vacancy::getSearchPageUrl(false, $city->slug) ?>"><?= $city->name ?></a>
                                    <?php endforeach; ?>
                                    <li class="content-list content-list_all-vacansy"><a href="">все города</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content-wrapper__search-job-block">
                            <div class="content-wrapper__search-job__content-block-categories__icon-block">
                                <div
                                        class="content-wrapper__search-job__content-block-categories__icon-block__container-forImg">
                                    <img class="icon-img" src="/images/main_page/lupa.png"></div>
                                <div class="content-wrapper__search-job__content-block-categories__icon-block__container-forP">
                                    <p>Вакансии по категориям</p><span>300+</span></div>

                            </div>
                            <div class="content-wrapper__search-job__content-block-list">
                                <ul class="content-block-list">
                                    <?php foreach ($categories as $category):?>
                                        <li class="content-list">
                                            <a href="<?= Vacancy::getSearchPageUrl($category->slug, false, false, $current_country?$current_country->slug:false) ?>">
                                                <?= $category->name ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="content-list content-list_all-vacansy">
                                        <a href="<?= Vacancy::getSearchPageUrl(false, false, false, $current_country?$current_country->slug:false) ?>">
                                            все профессии
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="content-wrapper__search-job-block">
                            <div class="content-wrapper__search-job__content-block-categories__icon-block">
                                <div
                                        class="content-wrapper__search-job__content-block-categories__icon-block__container-forImg">
                                    <img class="icon-img" src="/images/main_page/kaska.png"></div>
                                <div class="content-wrapper__search-job__content-block-categories__icon-block__container-forP">
                                    <p>Вакансии по профессиям</p><span>500+</span></div>

                            </div>
                            <div class="content-wrapper__search-job__content-block-list">
                                <ul class="content-block-list">
                                    <?php foreach ($professions as $profession):?>
                                        <li class="content-list">
                                            <a href="<?= Vacancy::getSearchPageUrl(false, false, $profession->slug, $current_country?$current_country->slug:false) ?>">
                                                <?= $profession->title ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <?php if($current_country):?>
                                        <li class="content-list content-list_all-vacansy">
                                            <a href="<?=Url::toRoute(["/$current_country->slug/professions"])?>">
                                                все профессии
                                            </a>
                                        </li>
                                    <?php else:?>
                                        <li class="content-list content-list_all-vacansy">
                                            <a href="<?=Url::toRoute(['/main_page/default/professions'])?>">
                                                все профессии
                                            </a>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="content-wrapper__search-job__waterMark">
                        <a class="craft_group"><img src="/images/main_page/data_image_png;base….png">Разработано в
                            CraftGroup</a>
                        <a class="questions_VK"><img src="/images/main_page/vk.svg">Есть вопросы?<br>Напиши нам в соц.сетях</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>








<div class="footer__usefull-links ">

    <ul class="footer__usefull-links__single-block"><p class="linkRabotaToday">Rabota Today</p>
        <li><a href="" class="usefull-link">О компании</a></li>
        <li><a href="" class="usefull-link">Наши вакансии</a></li>
        <li><a href="" class="usefull-link">Реклама на сайте</a></li>
        <li><a href="" class="usefull-link">Требования к ПО</a></li>
        <li><a href="" class="usefull-link">Защита персональных данных</a></li>
        <li><a href="" class="usefull-link">Безопасный HeadHunter</a></li>
        <li><a href="" class="usefull-link">Этика и компллаенс</a></li>
        <li><a href="" class="usefull-link">HeadHunter API</a></li>
        <li><a href="" class="usefull-link">Партнерам</a></li>
        <li><a href="" class="usefull-link">Инвесторам</a></li>
    </ul>

    <ul class="footer__usefull-links__single-block "><p class="linkRabotaToday">Rabota Today</p>
        <li><a href="" class="usefull-link">О компании</a></li>
        <li><a href="" class="usefull-link">Наши вакансии</a></li>
        <li><a href="" class="usefull-link">Реклама на сайте</a></li>
        <li><a href="" class="usefull-link">Требования к ПО</a></li>
        <li><a href="" class="usefull-link">Защита персональных данных</a></li>
        <li><a href="" class="usefull-link">Безопасный HeadHunter</a></li>
        <li><a href="" class="usefull-link">Этика и компллаенс</a></li>
        <li><a href="" class="usefull-link">HeadHunter API</a></li>
        <li><a href="" class="usefull-link">Партнерам</a></li>
        <li><a href="" class="usefull-link">Инвесторам</a></li>
    </ul>

    <ul class="footer__usefull-links__single-block"><p class="linkRabotaToday">Rabota Today</p>
        <li><a href="" class="usefull-link">О компании</a></li>
        <li><a href="" class="usefull-link">Наши вакансии</a></li>
        <li><a href="" class="usefull-link">Реклама на сайте</a></li>
        <li><a href="" class="usefull-link">Требования к ПО</a></li>
        <li><a href="" class="usefull-link">Защита персональных</a></li>
        <li><a href="" class="usefull-link">Безопасный HeadHunter</a></li>
        <li><a href="" class="usefull-link">Этика и компллаенс</a></li>
        <li><a href="" class="usefull-link">HeadHunter API</a></li>
        <li><a href="" class="usefull-link">Партнерам</a></li>
        <li><a href="" class="usefull-link">Инвесторам</a></li>
    </ul>

    <ul
            class=" footer__usefull-links__single-block footer__usefull-links__single-block__white-help footer__usefull-links__single-block__flex-order">
        <svg class="footer__usefull-links__single-block__white-help-treugol" width="15px"
             height="15px" viewBox="0 0 2 2" preserveAspectRatio="none">
            <polygon fill="#FFF" points="1,0 2,2 0,2"/>
        </svg>
        <li><img src="/images/main_page/interview.svg"></li>
        <li><p class="footer__usefull-links__single-block__white-help__p">Вопросы и ответы</p></li>
        <li><a href="" class="question">Как создать резюме?</a></li>
        <li><a href="" class="question">Нaстройки видимости резюме</a></li>
        <li><a href="" class="question">Как правильно написать сопроводительное письмо</a></li>
        <li class="question__margin"><a class="question" href="">Как происходит отклик на вакансию</a>
        </li>
    </ul>
    <span class="footer__usefull-links__span">© 2019–2020 Rabota.today.<br>
    Сайт поиска работы №1<br>в ДНР и ЛНР</span>
</div>
