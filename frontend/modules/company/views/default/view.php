<?php
/* @var $model Company */

use common\models\Company;
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
?>

?>
<div class="single-company mt30">
    <img class="single-company__dots2" src="/images/bg-dots.png" alt="" role="presentation"/>
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <div class="single-block single-block-slider">
            <div class="single-block__left">
                <div class="content-part">
                    <div class="content-part__block">
                        <p class="content-part__title">
                            <?=$model->name?>
                            <?php if($model->is_trusted):?>
                                <img src="/images/correct.png" alt="" id="small-img" role="presentation"/>
                            <?php endif ?>
                        </p>
                        <img class="content-part__logo" src="<?=$model->image_url?>" alt="" role="presentation"/>
                    </div>
                    <div class="content-part__block">
                        <?php if($model->is_trusted):?>
                            <p class="content-part__title">Проверенная компания</p>
                        <?php endif ?>
                        <div class="central" style="align-items: center;">
                            <img src="/images/chip.png" alt="" role="presentation"/>
                            <span><?=StringHelper::truncate($model->activity_field, 130, '...')?></span>
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
                <div class="description">
                    <?php foreach ($model->vacancy as $vacancy): ?>
                    <div class="vacancies">
                        <span class="vacancies__img"></span>
                        <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="vacancies__active"><?=$vacancy->post?></a>
                        <p class="vacancies__title"><?=$vacancy->employment_type?$vacancy->employment_type->name.', т':'Т'?>ребуемый опыт работы: <?=$vacancy->work_experience?Vacancy::$experiences[$vacancy->work_experience]:'Не имеет значения'?></p>
                    </div>
                    <?php endforeach ?>
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
                        <button class="sr-btn__btn btn btn-red <?=Yii::$app->user->isGuest?'jsLogin':'jsCompanyModal'?>" data-id="<?= $model->id ?>">Хочу тут работать</button>
                        <p class="sr-btn__text">На сайте</p>
                        <?php $months = array( 1 => 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' ); ?>
                        <p class="sr-btn__text">с <?=date('j '.$months[date( 'n', $model->created_at )].' Y', $model->created_at)?> г.</p>
                        <div class="single-block__view mt10">
                            <img class="single-block__icon mr5" src="/images/icon-eye.png" alt="" role="presentation"/>
                            <span><?=$model->countViews?></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>