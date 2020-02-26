<?php
/* @var $model Company */

use common\models\Company;
use common\models\Vacancy;
use yii\helpers\Url;

?>
<div class="single-company">
    <img class="single-company__dots2" src="/images/bg-dots.png" alt="" role="presentation"/>
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <ul class="result-search">
<!--            <li>Результаты поиска ·</li>-->
<!--            <li>Вакансии  в Донецке ·</li>-->
<!--            <li>Менеджер по холодным звонкамс</li>-->
        </ul>
        <div class="single-block single-block-slider">
            <div class="single-block__left">
                <div class="single-block__first">
                    <div class="category-block">
                        <a class="btn-card btn-card-small btn-gray" href="#">Мода и стиль</a>
                    </div>
                    <span>Добавлено:<br> <?=date('d m Y, H:i', $model->created_at)?></span>
                    <div class="single-block__view">
                        <img class="single-block__icon mr5" src="/images/icon-eye.png" alt="" role="presentation"/>
                        <span><?=$model->countViews?></span>
                    </div>
                    <a class="single-block__city d-flex align-items-center ml-auto mt5 mb5" href="#">
                        <img class="single-block__icon" src="/images/arr-place.png" alt="" role="presentation"/>
                        <span class="ml5">Санкт-Петербург</span>
                    </a>
                </div>
                <div class="content-part">
                    <div class="content-part__block">
                        <p class="content-part__title">
                            <?=$model->name?>
                            <?php if($model->is_trusted):?>
                                <img src="/images/correct.png" alt="" id="small-img" role="presentation"/>
                            <?php endif ?>
                        </p>
                        <img class="content-part__logo" src="<?=$model->image_url?>>" alt="" role="presentation"/>
                        <div class="vacancies">
                            <img class="vacancies__img" src="/images/vertical_line.png" alt="" role="presentation"/>
                            <p class="vacancies__title">Менеджер по персоналу</p>
                            <a class="vacancies__active" href="#">1 активная вакансия</a>
                        </div>
                    </div>
                    <div class="content-part__block">
                        <?php if($model->is_trusted):?>
                            <p class="content-part__title">Проверенная компания</p>
                        <?php endif ?>
                        <div class="central" style="align-items: center;">
                            <img src="/images/chip.png" alt="" role="presentation"/>
                            <span><?=$model->activity_field?></span>
                        </div>
                    </div>
<!--                    <div class="content-part__block"><img class="content-part__new" src="/images/new_item.png" alt="" role="presentation"/>-->
<!--                        <div class="right"><img src="/images/play-button.png" alt="" role="presentation"/><span>Вы можете записать свое видео резюме онлайн</span>-->
<!--                        </div>-->
<!--                    </div>-->
                </div><hr class="single-block__hr"/>
                <div class="description">
                    <h3>О компании:</h3>
                    <p><?=$model->description?></p>
                </div>
            </div>
            <aside class="single-block__right sidebar-single jsOpenContacts" id="sidebar-single">
                <div class="sidebar-inner">
                    <?php if($model->phone):?>
                        <div class="sidebar-inner__call-contact">
                            <img class="sidebar-inner__img" src="/images/vertical_line.png" alt="" role="presentation"/>
                            <p class="sidebar-inner__title">Менеджер по персоналу</p>
                            <p class="sidebar-inner__phone-number"><?=$model->phone->number?></p>
                        </div>
                    <?php endif ?>
                    <div class="single-block__soc">
                        <?php if ($model->hasSocials() && !Yii::$app->user->isGuest): ?>
                            <span>Написать соискателю в сетях</span>
                            <?php if ($model->vk): ?>
                                <a class="vk-bg" href="https://vk.com/<?= $model->vk ?>">
                                    <img src="/images/vk.svg" alt="" role="presentation"/>
                                </a>
                            <?php endif ?>
                            <?php if ($model->instagram): ?>
                                <a class="inst-bg" href="https://instagram.com/<?= $model->instagram ?>">
                                    <img src="/images/instagram.svg" alt="" role="presentation"/>
                                </a>
                            <?php endif ?>
                            <?php if($model->facebook): ?>
                                <a class="fb-bg" href="https://facebook.com/<?= $model->facebook ?>">
                                    <img src="/images/fb.svg" alt="" role="presentation"/>
                                </a>
                            <?php endif ?>
                        <?php endif; ?>
                    </div>
                    <div class="sr-btn">
                        <button class="sr-btn__btn btn btn-red jsVacancyModal">Хочу тут работать</button>
                        <p class="sr-btn__text">На сайте</p>
                        <?php $months = array( 1 => 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' ); ?>
                        <p class="sr-btn__text">с <?=date('j '.$months[date( 'n', $model->created_at )].' Y', $model->created_at)?> г.</p>
                    </div>
                    <div class="last-vacancy pc-last-vacancy">
                        <h2 class="last-vacancy__head">Вакансии компании</h2>
                        <?php foreach($model->vacancy as $vacancy): ?>
                        <div class="last-vacancy__item">
                            <div class="last-vacancy__tr"></div>
                            <div class="last-vacancy__header">
                                <img src="<?=$model->image_url?>" alt="" role="presentation"/>
                                <div class="last-vacancy__top">
                                    <div class="last-vacancy__cat-city">
                                        <a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($vacancy->mainCategory->slug)?>">
                                            <?=$vacancy->mainCategory->name?>
                                        </a>
                                    </div>
                                    <a class="last-vacancy__title" href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" title="Дизайнер презентаций">
                                        <?=$vacancy->post?>
                                    </a>
                                </div>
                            </div>
                            <div class="last-vacancy__info">
                                <p><?=$vacancy->qualification_requirements?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
            <div class="last-vacancy mob-last-vacancy">
                <h2 class="last-vacancy__head">Последние вакансии</h2>
                <?php foreach($model->vacancy as $vacancy): ?>
                    <div class="last-vacancy__item">
                        <div class="last-vacancy__tr"></div>
                        <div class="last-vacancy__header">
                            <img src="<?=$model->image_url?>" alt="" role="presentation"/>
                            <div class="last-vacancy__top">
                                <div class="last-vacancy__cat-city">
                                    <a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($vacancy->mainCategory->slug)?>">
                                        <?=$vacancy->mainCategory->name?>
                                    </a>
                                </div>
                                <a class="last-vacancy__title" href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" title="<?=$vacancy->post?>">
                                    <?=$vacancy->post?>
                                </a>
                            </div>
                        </div>
                        <div class="last-vacancy__info">
                            <p><?=$vacancy->qualification_requirements?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>