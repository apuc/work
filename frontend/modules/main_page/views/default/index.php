<?php

/* @var $this \yii\web\View */
/* @var $categories \common\models\Category[] */
/* @var $vacancies \common\models\Vacancy[] */
/* @var $employer \common\models\Employer */


use common\models\KeyValue;
use common\models\Vacancy;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = KeyValue::findValueByKey('main_page_title') ?: 'Работа: главная';
$this->registerMetaTag(['description' => KeyValue::findValueByKey('main_page_description')]);
?>

<div class="nhome">
    <div class="nhome__main">
        <div class="nhome-white-line">
            <div class="nhome-white-line__square">
            </div>
        </div>
        <div class="nhome-white-line">
            <div class="nhome-white-line__square">
            </div>
        </div>
        <div class="nhome-white-line">
            <div class="nhome-white-line__square">
            </div>
        </div>
        <div class="nhome__main-top">
            <div class="nhome__main-header">
                <button class="mobile-nav-btn jsOpenNavMenu"><span></span><span></span><span></span>
                </button>
                <div class="filter-overlay nav-overlay jsNavOverlay">
                </div>
                <nav class="nhome__nav jsNavMenu">
                    <a class="nhome__nav-item nhome__nav-item_logo" href="/">
                        <img src="/images/logo-main.png" alt="" role="presentation"/>
                    </a>
                    <a class="nhome__nav-item" href="<?=Url::to(['/resume/default/search'])?>">Поиск резюме</a>
                    <a class="nhome__nav-item" href="<?=Url::to(['/vacancy/default/search'])?>">Поиск вакансий</a>
                    <?php if (Yii::$app->user->isGuest): ?>
                    <button class="nhome__nav-item nav-btn jsLogin">
                        Вход
                    </button>
                    <?php else: ?>
                    <div class="dropdown jsMenu">
                        <span class="nhome__nav-item nav-btn jsOpenMenu">
                            <?php if(!$employer->first_name && !$employer->second_name):?>
                            <?=Yii::$app->user->identity->email?>
                            <?php else:?>
                            <?= $employer->first_name.' '.$employer->second_name ?>
                            <?php endif?>
                            <span>></span>
                        </span>
                        <div class="dropdown__menu jsShowMenu">
                            <span class="nhome__nav-item mobile-prev jsMenuPrev">Назад</span>
                            <a class="nhome__nav-item" href="<?=Url::to(['/personal_area/default/index'])?>">Личный кабинект</a>
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
                <?= Html::beginForm(['/main_page/default/search'], 'post', ['class' => 'nhome__form']) ?>
                    <span class="nhome__form-text">Сейчас на сайте свыше <span class='white-text'> <?=Vacancy::find()->count()?> вакансий </span> и <span
                                class='white-text'> <?=\common\models\Resume::find()->count()?> резюме</span></span>
                    <input name="search_text" class="nhome__form-input" placeholder="Я ищу..." type="text"/>
                    <div class="nhome__form-select">
                        <select name="search_type" class="home__form-select-js">
                            <option value="vacancy">Работу</option>
                            <option value="resume">Сотрудников</option>
                        </select>
                    </div>
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i>',
                    ['class' => 'nhome__search btn-red']
                ) ?>
                <?= Html::endForm() ?>
                <a class="btn btn-red mr20" href="/personal-area/add-resume">разместить резюме</a>
                <a class="btn btn-red" href="<?=Url::to(['/vacancy/default/search'])?>">Найти вакансии</a>
            </div>
        </div>
        <div class="nhome__main-bottom">
            <img class="nhome__main-big-circle" src="/images/home-big-circle.png" alt="" role="presentation"/>
            <img class="nhome__main-gerb" src="/images/gerb-doneck-z1.png" alt="" role="presentation"/>
            <h1 class="nhome__title">Работа</h1>
            <p class="nhome__desc">Сделайте грамотный выбор! Предлагаем размещение и продвижение на новой и
                перспективной площадке <span class="yellow-text">РаботаДНР</span>. Станьте первым и получайте максимум
                продаж, опережая конкурентов на несколько шагов. Полностью берем на себя все, что связано с размещением
                на маркетплейсе, эффективно управляем ценами и поставками
            </p>
            <img class="nhome__main-bottom-img" src="/images/img1.png" img="" alt="" role="presentation"/>
        </div>
    </div>
    <aside class="nhome__aside">
        <img class="nhome__dots2" src="/images/bg-dots.png" alt="" role="presentation"/>
        <div class="nhome__aside-header">
            <h3 class="nhome__aside-header-vacancy">Вакансии дня</h3>
        </div>
        <div class="home__slider">
            <?php foreach ($vacancies as $vacancy): ?>
            <div class="single-card home-card">
                <div class="single-card__tr">
                </div>
                <div class="single-card__header">
                    <img src="<?=$vacancy->company->getPhotoOrEmptyPhoto()?>" alt="" role="presentation"/>
                    <div class="single-card__top">
                        <div class="single-card__cat-city">
                            <?php if($vacancy->category):?>
                            <a class="btn-card btn-card-small btn-gray" href="<?=Url::to(['/vacancy/default/search', 'category_ids' => json_encode([$vacancy->category[0]->id])])?>"><?=$vacancy->category[0]->name?></a>
                            <?php endif ?>
                            <a class="d-flex align-items-center" href="<?=Url::to(['/vacancy/default/search', 'city' => $vacancy->city])?>">
                                <img class="single-card__icon" src="/images/arr-place.png" alt="" role="presentation"/>
                                <span class="ml5"><?=$vacancy->city?></span>
                            </a>
                        </div>
                        <a href="<?=Url::to(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="single-card__title" title="<?=$vacancy->post?>"><?=$vacancy->post?></a>
                        <div class="single-card__info-second"><span class="mr10">Добавлено: <?= Yii::$app->formatter->asTime($vacancy->created_at, 'dd MM yyyy, hh:mm') ?></span>
                            <div class="single-card__view"><img class="single-card__icon mr5" src="/images/icon-eye.png"
                                                                alt="" role="presentation"/><span><?=$vacancy->views?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-card__info">
                    <?php if($vacancy->employment_type):?>
                    <p><?=$vacancy->employment_type->name?>.</p>
                    <?php endif ?>
                    <p><?=StringHelper::truncate($vacancy->responsibilities, 80, '...')?></p>
                </div>
                <?php if(!Yii::$app->user->isGuest):?>
                <div class="d-flex flex-wrap align-items-center justify-content-start mt-auto">
                    <a class="btn-card btn-red jsVacancyModal" data-id="<?=$vacancy->id?>">Откликнуться</a>
<!--                    <a class="single-card__like" href="#">-->
<!--                        <i class="fa fa-heart-o"></i>-->
<!--                        <span>В избранное</span>-->
<!--                    </a>-->
                </div>
                <?php endif ?>
            </div>
            <?php endforeach ?>
        </div>
    </aside>
    <div class="nhome__footer">

    <?php
    $i=0;
    foreach($categories as $category): ?>
    <?php if($i<9): ?>
        <a class="nhome__footer-item" href="<?=Url::to(['/vacancy/default/search', 'category_ids' => json_encode([$category->id])])?>"><?=$category->name?> <?=$category->getVacancyCategories()->count()?></a>
    <?php else:?>
        <a class="nhome__footer-item mob-hide" href="<?=Url::to(['/vacancy/default/search', 'category_ids' => json_encode([$category->id])])?>"><?=$category->name?> <?=$category->getVacancyCategories()->count()?></a>
    <?php
    endif;
    $i++;
    endforeach; ?>
        <a class="nhome__footer-item" href="#"></a>
    </div>
    <img class="nhome__dots1" src="/images/bg-dots.png" alt="" role="presentation"/>
    <img class="nhome__circle" src="/images/circle.png" alt="" role="presentation"/>
</div>