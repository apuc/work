<?php
/* @var $model Company */
/* @var $cities City[] */
/* @var $last_vacancies Vacancy[] */

use common\models\City;
use common\models\Company;
use common\models\User;
use common\models\Vacancy;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = "Вакансии компании $model->name на сайте rabota.today";
$description = "Список открытых вакансий компании $model->name, контакты и отзывы. На сайте поиска работы №1 rabota.today";

$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name' => 'og:image', 'content' => '/images/og_image.jpg']);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);
$months = array(1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
?>

<div class="single-company">
    <img class="single-company__dots2" src="/images/bg-dots.png" alt="Точки" role="presentation">
    <img src="/images/bg_round.png" alt="Круг" id="round-left" role="presentation">
    <img src="/images/bg_round.png" alt="Круг" id="round-right" role="presentation">
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <div class="single-block single-block-slider">
            <div class="single-block__left">
                <div class="single-block__first">
                    <span class="ml0">Добавлено:<br> <?=date('j '.$months[date( 'n', $model->created_at )].' Y, H:i', $model->created_at)?></span>
                    <div class="single-block__view">
                        <img class="single-block__icon mr5" src="/images/icon-eye.png" alt="Иконка глаз" role="presentation"/>
                        <span><?=$model->countViews?></span>
                    </div>
                    <div class="single-block__city d-flex align-items-center ml-auto mt5 mb5" href="#">
                        <img class="single-block__icon" src="/images/arr-place.png" alt="Стрелка" role="presentation"/>
                        <span class="ml5">
                            <?php
                                $count = 0;
                                foreach ($cities as $city):
                            ?>
                                <a class="single-block__city" href="<?=Vacancy::getSearchPageUrl(false, $city->slug)?>"><?=$city->name?><?=$count<(count($cities)-1)?',':''?></a>
                            <?php
                                $count++;
                                endforeach;
                            ?>
                        </span>
                    </div>
                </div>

                <p class="content-part__title">
                    <?=$model->name?>
                    <?php if($model->is_trusted):?>
                        <img src="/images/correct.png" alt=Галочка"" id="small-img" role="presentation" title="Проверенная компания"/>
                    <?php endif ?>
                </p>

                <div class="content-part">



                    <div class="content-part__block">

                        <img class="content-part__logo" src="<?=$model->image_url?>" alt="" role="presentation"/>
                    </div>
                    <div class="content-part__block">
                        <div class="central" style="align-items: center;">
                            <img src="/images/chip.png" alt="Чип" role="presentation"/>
                            <span><?=StringHelper::truncate($model->activity_field, 130, '...')?></span>
                        </div>
                    </div>
                    <div class="content-part__block">
                        <div class="right">
                            <?php $email = User::findOne($model->owner)->email;?>
                            <span><a href="mailto:<?=$email?>"><?=$email?></a><br>
                                <?php if($model->website):?>
                                    <a href="<?=$model->website?>"  target="_blank" rel="ugc"><?=$model->website?></a></span>
                                <?php endif ?>
                            <span></span>
                        </div>
                    </div>
                </div><hr class="single-block__hr"/>
                <div class="description">
                    <?php if($model->description):?>
                        <h3>О компании:</h3>
                        <p><?=$model->description?></p>
                    <?php endif ?>
                </div>
                <div class="description">
                    <h3 style="margin-top: 10px">Открытые вакансии <?=$model->name?></h3>
                    <?php foreach ($model->activeVacancies as $vacancy): ?>
                    <div class="vacancies">
                        <span class="vacancies__img"></span>
                        <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="vacancies__active"><?=$vacancy->post?></a>
                        <p class="vacancies__title"><?=$vacancy->employment_type?$vacancy->employment_type->name.', т':'Т'?>ребуемый опыт работы: <?=$vacancy->work_experience?Vacancy::$experiences[$vacancy->work_experience]:'Не имеет значения'?></p>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
            <aside class="single-block__right sidebar-single jsOpenContacts mt20" id="sidebar-single">
                <div class="sidebar-inner">
                    <?php if($model->phone):?>
                        <div class="sidebar-inner__call-contact">
                            <img class="sidebar-inner__img" src="/images/vertical_line.png" alt="Линия" role="presentation"/>
                            <p class="sidebar-inner__title">Менеджер по персоналу</p>
                            <a class="sidebar-inner__phone-number hide-phone jsShowPhone" href="tel:<?=$model->phone->number?>"><?=$model->phone->number?></a>
                            <button
                                data-id="<?=$model->id?>"
                                data-type="company"
                                class="show-phone ml15 jsClickShowPhone mt5"
                                onclick="gtag('event', 'company_phone', { 'event_category': 'click', 'event_action': 'company_phone', }); yaCounter53666866.reachGoal('company_phone'); return true;"
                            >Позвонить</button>
                        </div>
                    <?php endif ?>
                    <div class="single-block__soc company-soc">
                        <?php if ($model->hasSocials() && !Yii::$app->user->isGuest): ?>
                            <?php if ($model->vk): ?>
                                <a class="vk-bg" href="https://vk.com/<?= $model->vk ?>">
                                    <img src="/images/vk.svg" alt="Иконка VK" role="presentation"/>
                                </a>
                            <?php endif ?>
                            <?php if ($model->instagram): ?>
                                <a class="inst-bg" href="https://instagram.com/<?= $model->instagram ?>">
                                    <img src="/images/instagram.svg" alt="Иконка instagram" role="presentation"/>
                                </a>
                            <?php endif ?>
                            <?php if($model->facebook): ?>
                                <a class="fb-bg" href="https://facebook.com/<?= $model->facebook ?>">
                                    <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/>
                                </a>
                            <?php endif ?>
                        <?php endif; ?>
                    </div>
                    <div class="sr-btn">
                        <button class="sr-btn__btn btn btn-red <?=Yii::$app->user->isGuest?'jsLogin':'jsCompanyModal'?>" data-id="<?= $model->id ?>">Хочу тут работать</button>
                        <p class="sr-btn__text">На сайте</p>
                        <p class="sr-btn__text">с <?=date('j '.$months[date( 'n', $model->created_at )].' Y', $model->created_at)?> г.</p>
                        <div class="single-block__view mt10">
                            <img class="single-block__icon mr5" src="/images/icon-eye.png" alt="Иконка глаз" role="presentation"/>
                            <span><?=$model->countViews?></span>
                        </div>
                    </div>
                    <div class="last-vacancy pc-last-vacancy">
                        <h2 class="last-vacancy__head">Последние вакансии
                        </h2>
                        <?php foreach ($last_vacancies as $vacancy): ?>
                        <div class="last-vacancy__item">
                            <div class="last-vacancy__tr">
                            </div>
                            <div class="last-vacancy__header">
                                <img src="<?=$vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory)?>"
                                     alt="<?=$vacancy->company->image_url?('Логотив компани '.$vacancy->company->name):'Пустая компания'?>"
                                     role="presentation"
                                />
                                <div class="last-vacancy__top">
                                    <div class="last-vacancy__cat-city"><a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($vacancy->mainCategory->slug)?>"><?=$vacancy->mainCategory->name?></a>
                                    </div><a class="last-vacancy__title" href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" title="Дизайнер презентаций"><?=$vacancy->post?></a>
                                </div>
                            </div>
                            <div class="last-vacancy__info">
                                <p><?=$vacancy->responsibilities?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
            <div class="last-vacancy mob-last-vacancy">
                <h2 class="last-vacancy__head">Последние вакансии
                </h2>
                <?php foreach ($last_vacancies as $vacancy): ?>
                    <div class="last-vacancy__item">
                        <div class="last-vacancy__tr">
                        </div>
                        <div class="last-vacancy__header">
                            <img src="<?=$vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory)?>"
                                 alt="<?=$vacancy->company->image_url?('Логотив компани '.$vacancy->company->name):'Пустая компания'?>"
                                 role="presentation"
                            />
                            <div class="last-vacancy__top">
                                <div class="last-vacancy__cat-city"><a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($vacancy->mainCategory->slug)?>"><?=$vacancy->mainCategory->name?></a>
                                </div>
                                <a class="last-vacancy__title" href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" title="Дизайнер презентаций"><?=$vacancy->post?></a>
                            </div>
                        </div>
                        <div class="last-vacancy__info">
                            <p><?=$vacancy->responsibilities?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>