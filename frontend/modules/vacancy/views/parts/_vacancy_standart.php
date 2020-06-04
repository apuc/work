<?php

/** @var \common\models\Vacancy $vacancy */
/** @var bool $flag */
/* @var $searchModel \frontend\modules\vacancy\classes\VacancySearch */

use common\classes\MoneyFormat;
use common\helpers\StringHelper;
use common\models\Vacancy;
use yii\helpers\Url;
?>

<div class="single-card" <?=$flag?'style="background-color: #676767"':''?>>
    <div class="single-card__tr">
    </div>
    <div class="single-card__header">
        <a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($vacancy->mainCategory->slug)?>"><?= $vacancy->mainCategory->name ?></a>
        <?php foreach ($vacancy->category as $category): ?>
            <?php if($category->id != $vacancy->main_category_id):?>
                <a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($category->slug)?>"><?= $category->name ?></a>
            <?php endif ?>
        <?php endforeach ?>
        <img class="single-card__image" src="<?=$vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory)?>"
             alt="<?=$vacancy->company->image_url?('Логотив компани '.$vacancy->company->name):'Пустая компания'?>"
             role="presentation"
        />
    </div>
    <!--<a href="<?/*=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id, 'referer_category'=>$vacancy->main_category_id])*/?>" class="single-card__title mt5">
                                <?/*= mb_convert_case ( $vacancy->post , MB_CASE_TITLE) */?>
                            </a>-->
    <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="single-card__title mt5">
        <?= StringHelper::mb_ucfirst( $vacancy->post , MB_CASE_TITLE) ?>
    </a>
    <div class="single-card__company">
        <p><?= $vacancy->company->name ?>
            <?php if($vacancy->company->is_trusted):?>
                <img src="/images/correct.png" alt=Галочка"" id="small-img" role="presentation" title="Проверенная компания"/>
            <?php endif ?>
        </p>
    </div>
    <div class="single-card__info-second"><span
            class="mr10">Добавлено: <?= Yii::$app->formatter->asDate($vacancy->update_time, 'dd.MM.yyyy') ?></span>
        <?php if ($vacancy->views > 0):?>
            <div class="single-card__view">
                <img class="single-card__icon mr5" src="/images/icon-eye.png" alt="Иконка глаз"role="presentation"/>
                <span><?= $vacancy->views ?></span>
            </div>
        <?php endif ?>
        <a class="d-flex align-items-center mt5 mb5" href="<?=Vacancy::getSearchPageUrl(false, $vacancy->city0?$vacancy->city0->slug:false)?>">
            <img class="single-card__icon" src="/images/arr-place.png" alt="Стрелка" role="presentation"/>
            <span class="ml5"><?= $vacancy->city0?$vacancy->city0->name:'' ?></span>
        </a>
    </div>
    <span class="single-card__price">
                                <?php if($vacancy->min_salary && $vacancy->max_salary):?>
                                    <?= MoneyFormat::getFormattedAmount($vacancy->min_salary) ?> - <?= MoneyFormat::getFormattedAmount($vacancy->max_salary) ?> ₽
                                <?php elseif ($vacancy->min_salary):?>
                                    От <?= MoneyFormat::getFormattedAmount($vacancy->min_salary)?> ₽
                                <?php elseif ($vacancy->max_salary):?>
                                    До <?= MoneyFormat::getFormattedAmount($vacancy->max_salary)?> ₽
                                <?php else: ?>
                                    Зарплата договорная
                                <?php endif?>
                            </span>
    <div class="single-card__info">
        <p><?= nl2br(StringHelper::truncate($vacancy->responsibilities, 80, '...')) ?></p>
    </div>
    <div class="single-card__bottom">
        <div class="single-card__info__soc">
            <?php if($vacancy->company->hasSocials()): ?>
                <span>Написать работодателю в сетях</span>
                <?php if($vacancy->company->vk):?>
                    <a target="_blank" class="vk-bg" rel="nofollow" href="https://vk.com/<?=$vacancy->company->vk?>">
                        <img src="/images/vk.svg" alt="Иконка VK" role="presentation"/>
                    </a>
                <?php endif ?>
                <?php if($vacancy->company->instagram):?>
                    <a target="_blank" class="inst-bg" rel="nofollow" href="https://instagram.com/<?=$vacancy->company->instagram?>">
                        <img src="/images/instagram.svg" alt="Иконка instagram" role="presentation"/>
                    </a>
                <?php endif ?>
                <?php if($vacancy->company->facebook):?>
                    <a target="_blank" class="fb-bg" rel="nofollow" href="https://facebook.com/<?=$vacancy->company->facebook?>">
                        <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/>
                    </a>
                <?php endif ?>
            <?php endif ?>
        </div>
        <?php if($searchModel->category_ids && count($searchModel->category_ids) === 1):?>
            <!-- <a href="<?/*=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id, 'referer_category'=>$searchModel->category_ids[0]])*/?>" class="btn-card btn-red">
                                        Посмотреть полностью
                                    </a>-->
            <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="btn-card btn-red">
                Посмотреть полностью
            </a>
        <?php else: ?>
            <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="btn-card btn-red">
                Посмотреть полностью
            </a>
        <?php endif ?>
    </div>
</div>