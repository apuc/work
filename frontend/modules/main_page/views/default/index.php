<?php

/* @var $this \yii\web\View */
/* @var $categories \common\models\Category[] */
/* @var $vacancies \common\models\Vacancy[] */
/* @var $employer \common\models\Employer */


use common\models\KeyValue;
use common\models\Resume;
use common\models\Vacancy;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = KeyValue::findValueByKey('main_page_title') ?: 'Работа: главная';
$this->registerMetaTag(['name'=>'description', 'content' => KeyValue::findValueByKey('main_page_description')]);
$this->registerMetaTag(['name'=>'og:title', 'content' => $this->title]);
$this->registerMetaTag(['name'=>'og:type', 'content' => 'website']);
$this->registerMetaTag(['name'=>'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name'=>'og:image', 'content' => Yii::$app->urlManager->hostInfo.'/images/logo-main.png']);
$this->registerMetaTag(['name'=>'og:description', 'content' => KeyValue::findValueByKey('main_page_description')]);
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
                <button class="mobile-nav-btn jsOpenNavMenu"><img src="/images/menu.png" alt="" role="presentation"/>
                </button>
                <div class="filter-overlay nav-overlay jsNavOverlay">
                </div>
                <nav class="nhome__nav jsNavMenu">
                    <a class="nhome__nav-item nhome__nav-item_logo" href="/">
                        <img src="/images/logo-main.png" alt="" role="presentation"/>
                        <img src="/images/logo_mob.png" alt="" role="presentation"/>
                    </a>
                    <?=''
//                    \kartik\select2\Select2::widget(
//                        [
//                            'name' => 'CitySelect',
//                            'value' => Yii::$app->request->cookies['city'],
//                            'data' => ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name'),
//                            'options' => ['placeholder' => 'Выберите город', 'id'=>'city_select'],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]
                    //);
?>
                    <a class="nhome__nav-item" href="<?=Resume::getSearchPageUrl()?>">Поиск резюме</a>
                    <a class="nhome__nav-item" href="<?=Vacancy::getSearchPageUrl()?>">Поиск вакансий</a>
                    <?php if (Yii::$app->user->isGuest): ?>
                    <button class="nhome__nav-item nav-btn jsLogin">
                        Вход
                    </button>
                    <?php else: ?>
                    <div class="dropdown jsMenu">
                        <span class="nhome__nav-item nav-btn jsOpenMenu">
                            <?php if(!$employer->first_name && !$employer->second_name):?>
                            <?=explode('@', Yii::$app->user->identity->email)[0]?>
                            <?php else:?>
                            <?= $employer->first_name.' '.$employer->second_name ?>
                            <?php endif?>
                            <img src="/images/down-arrow.svg" alt="" role="presentation"/>
                            <span>></span>
                        </span>
                        <div class="dropdown__menu jsShowMenu">
                            <span class="nhome__nav-item mobile-prev jsMenuPrev">Назад</span>
                            <?php $messages=Yii::$app->user->identity->unreadMessages ?>
                            <a class="nhome__nav-item" href="<?=Url::to(['/personal_area/default/index'])?>">Личный кабинет</a>
                            <a class="nhome__nav-item" href="<?=Url::to(['/personal-area/my-message'])?>">Сообщения <?=$messages>0?"($messages)":""?></a>
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
                <?= Html::beginForm([Vacancy::getSearchPageUrl()], 'get', ['class' => 'nhome__form']) ?>
                    <span class="nhome__form-text">
                        Сейчас на сайте свыше
                        <a href="<?=Vacancy::getSearchPageUrl()?>" class='white-text'> <?=Vacancy::find()->count()?> вакансий </a> и
                        <a href="<?=Resume::getSearchPageUrl()?>" class='white-text'> <?=Resume::find()->count()?> резюме</a>
                    </span>
                <input name="search_text" class="nhome__form-input" placeholder="Я ищу..." type="text"/>
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i>',
                    ['class' => 'nhome__search btn-red']
                ) ?>
                <?= Html::endForm() ?>
                <a class="btn btn-red mr20" href="/personal-area/add-resume">разместить резюме</a>
                <a class="btn btn-red" href="/personal-area/add-vacancy">создать вакансию</a>
            </div>
        </div>
        <div class="nhome__main-bottom">
            <img class="nhome__main-big-circle" src="/images/home-big-circle.png" alt="" role="presentation"/>
            <img class="nhome__main-gerb" src="/images/gerb-doneck-z1.png" alt="" role="presentation"/>
            <h1 class="nhome__title">Работа</h1>
            <p class="nhome__desc desc-pc">Сделайте грамотный выбор! Предлагаем размещение и продвижение на новой и
                перспективной площадке <span class="yellow-text">РаботаДНР</span>. Станьте первым и получайте максимум
                продаж, опережая конкурентов на несколько шагов. Полностью берем на себя все, что связано с размещением
                на маркетплейсе, эффективно управляем ценами и поставками
            </p>
            <p class="nhome__desc desc-mob">Сделайте грамотный выбор! Предлагаем размещение и продвижение на новой и
                перспективной площадке <span class="yellow-text">РаботаДНР</span>.
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
                            <?php $category_slug = $vacancy->category[0]->slug ?>
                            <a class="btn-card btn-card-small btn-gray" href="<?=Url::to(["/vacancy/$category_slug"])?>"><?=$vacancy->category[0]->name?></a>
                            <?php endif ?>
                            <?php $city = \common\models\City::findOne(['name'=>$vacancy->city])?>
                            <?php if($city): ?>
                            <a class="d-flex align-items-center" href="<?=Url::to(["/vacancy/$city->slug"])?>">
                                <img class="single-card__icon" src="/images/arr-place.png" alt="" role="presentation"/>
                                <span class="ml5"><?=$vacancy->city?></span>
                            </a>
                            <?php endif ?>
                        </div>
                        <a href="<?=Url::to(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="single-card__title" title="<?=$vacancy->post?>"><?=$vacancy->post?></a>
                        <div class="single-card__info-second"><span class="mr10">Добавлено: <?= Yii::$app->formatter->asTime($vacancy->created_at, 'dd MM yyyy, hh:mm') ?></span>
                            <div class="single-card__view"><img class="single-card__icon mr5" src="/images/icon-eye.png"
                                                                alt="" role="presentation"/><span><?=$vacancy->countViews?></span>
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
                <div class="d-flex flex-wrap align-items-center justify-content-start">
                    <a class="btn-card btn-red jsVacancyModal" data-id="<?=$vacancy->id?>">Откликнуться</a>
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

    <?php
    $i=0;
    foreach($categories as $category): ?>
    <?php if($i<9): ?>
        <a class="nhome__footer-item" href="<?=Url::toRoute(['/vacancy/'.$category->slug])?>"><?=$category->name?> <?=$category->getVacancyCategories()->count()?></a>
    <?php else:?>
        <a class="nhome__footer-item mob-hide" href="<?=Url::toRoute(['/vacancy/'.$category->slug])?>"><?=$category->name?> <?=$category->getVacancyCategories()->count()?></a>
    <?php
    endif;
    $i++;
    endforeach; ?>
        <a class="nhome__footer-item" href="#"></a>
    </div>
    <img class="nhome__dots1" src="/images/bg-dots.png" alt="" role="presentation"/>
    <div class="nhome__circle"></div>
</div>