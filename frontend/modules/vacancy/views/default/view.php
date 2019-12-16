<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Vacancy */
/* @var $last_vacancies \common\models\Vacancy[] */

use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = $model->post;
$this->registerMetaTag(['name'=>'description', 'content' => \yii\helpers\StringHelper::truncate($model->qualification_requirements, 100, '...')]);
$this->registerMetaTag(['name'=>'og:title', 'content' => $model->post]);
$this->registerMetaTag(['name'=>'og:type', 'content' => 'website']);
$this->registerMetaTag(['name'=>'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name'=>'og:image', 'content' => $model->company->image_url?:'/images/empty_user.jpg']);
$this->registerMetaTag(['name'=>'og:description', 'content' => StringHelper::truncate($model->qualification_requirements, 100, '...')]);
?>

<section class="single-vacancy"><img class="single-vacancy__dots2" src="/images/bg-dots.png" alt=""
                                     role="presentation"/>
    <div class="single-vacancy__circle">
    </div>
    <div class="container">
        <ul class="result-search">
            <li>Результаты поиска · </li>
            <li>
            <?php if($model->city):?>
            <?= $model->city ?>
            <?php endif?> · </li>
            <li><?= $model->post ?></li>
        </ul>
        <div class="single-block single-block-slider">
            <button class="mobile-contacts jsShowContacts jsShowContactsFlag"><img
                        src="/images/add-contact.svg" alt="" role="presentation"/>
            </button>
            <div class="single-block__left">
                <img class="single-block__logo" src="<?=$model->company->getPhotoOrEmptyPhoto()?>" alt=""
                     role="presentation"/>
                <div class="single-block__first">
                    <div class="category-block">
                        <?php foreach ($model->category as $category): ?>
                            <a class="btn-card btn-card-small btn-gray" href="<?=\yii\helpers\Url::to(['/vacancy/search', 'category_ids' => json_encode([$category->id])])?>"><?= $category->name ?></a>
                        <?php endforeach ?>
                    </div>
                    <span>Добавлено:<br> <?= Yii::$app->formatter->asDate($model->created_at, 'dd MM yyyy') ?></span>
                    <div class="single-block__view"><img class="single-block__icon mr5"
                                                                      src="/images/icon-eye.png" alt=""
                                                                      role="presentation"/><span><?= $model->views ?></span>
                    </div>
                    <a class="single-block__city d-flex align-items-center ml-auto mt5 mb5"
                       href="<?=\yii\helpers\Url::to(["/vacancy/search/город:$model->city"])?>"><img class="single-block__icon" src="/images/arr-place.png" alt=""
                                     role="presentation"/><span class="ml5"><?= $model->city ?></span></a>
                </div>
                <h1 class="single-block__head"><?= $model->post ?>
                </h1>
                <div class="single-block__price">
                    <span>
                        <?php if($model->min_salary && $model->max_salary):?>
                            <?= $model->min_salary ?>-<?= $model->max_salary ?> RUB
                        <?php elseif ($model->min_salary):?>
                            От <?= $model->min_salary ?> RUB
                        <?php elseif ($model->max_salary):?>
                            До <?= $model->max_salary ?> RUB
                        <?php else: ?>
                            Зарплата договорная
                        <?php endif?>
                    </span>
                    <div class="single-block__soc">
                        <?php if ($model->company->hasSocials()): ?>
                            <span>Написать соискателю в сетях</span>
                            <?php if ($model->company->vk): ?><a class="vk-bg" target="_blank" href="<?= $model->company->vk ?>"><img
                                        src="/images/vk.svg" alt="" role="presentation"/></a><?php endif ?>
                            <?php if ($model->company->instagram): ?><a class="ok-bg" target="_blank"
                                                                        href="<?= $model->company->instagram ?>"><img
                                            src="/images/ok.svg" alt="" role="presentation"/></a><?php endif ?>
                            <?php if ($model->company->facebook): ?><a class="fb-bg" target="_blank"
                                                                       href="<?= $model->company->facebook ?>"><img
                                            src="/images/fb.svg" alt="" role="presentation"/></a><?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="single-block__employment">
                    <?php if($model->employment_type):?>
                    <h3 class="single-block__employment-head">Вид занятости:
                    </h3>
                    <p class="single-block__employment-text"><?= $model->employment_type->name ?>
                    </p>
                    <?php endif ?>
                </div>
                <?php if($model->company->description):?>
                    <div class="single-block__description">
                        <h3 class="single-block__description-head">Описание вакансии
                        </h3>
                        <p class="single-block__requirements-text"><?= $model->company->description ?></p>
                    </div>
                <?php endif ?>
                <?php if($model->qualification_requirements):?>
                    <div class="single-block__requirements">
                        <h3 class="single-block__requirements-head">Требования:
                        </h3>
                        <p class="single-block__requirements-text"><?= nl2br($model->qualification_requirements) ?></p>
                    </div>
                <?php endif ?>
                <?php if($model->responsibilities):?>
                    <div class="single-block__duties">
                        <h3 class="single-block__duties-head">Обязанности:
                        </h3>
                        <p class="single-block__duties-text"><?= nl2br($model->responsibilities) ?></p>
                    </div>
                <?php endif ?>
                <?php if($model->working_conditions):?>
                    <div class="single-block__conditions">
                        <h3 class="single-block__conditions-head">Условия работы:
                        </h3>
                        <p class="single-block__conditions-text"><?= nl2br($model->working_conditions) ?></p>
                    </div>
                <?php endif ?>
            </div>
            <aside class="single-block__right sidebar-single jsOpenContacts" id="sidebar-single">
                <div class="single-vacancy-overlay jsHideContacts">
                </div>
                <div class="sidebar-inner">
                    <button class="mobile-contacts sidebar-mobile-contacts jsShowContacts"><img src="assets/images/add-contact.svg" alt="" role="presentation"/>
                    </button>
                    <div class="sr-block">
                        <ul class="sr-block__text">
                            <?php if(!empty($model->company->name)):?>
                            <li class="sr-block__text__company">
                                <p><strong>Компания:</strong><?= $model->company->name ?><br> <?= $model->company->activity_field ?>
                                </p>
                            </li>
                            <?php endif ?>
                            <li class="sr-block__text__contact">
                                <p><strong>Контактное лицо:</strong><?= $model->company->contact_person ?>
                                </p>
                            </li>
                            <?php if ($model->company->phone): ?>
                            <li class="sr-block__text__phone"><img src="/images/phone.svg" alt="" role="presentation"/>
                                <div><strong>Телефон:</strong><a href="tel:<?= $model->company->phone->number ?>"><?= $model->company->phone->number ?></a>
                                </div>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="sr-btn">
                        <button class="sr-btn__btn btn btn-red jsVacancyModal" data-id="<?=$model->id?>">Отправить резюме
                        </button>
                    </div>
                    <div class="last-vacancy pc-last-vacancy">
                        <h2 class="last-vacancy__head">Последние вакансии
                        </h2>
                        <?php foreach ($last_vacancies as $vacancy):?>
                        <div class="last-vacancy__item">
                            <div class="last-vacancy__tr">
                            </div>
                            <div class="last-vacancy__header"><img src="<?=$vacancy->company->getPhotoOrEmptyPhoto()?>" alt="" role="presentation"/>
                                <div class="last-vacancy__top">
                                    <?php if($vacancy->category):?>
                                    <div class="last-vacancy__cat-city">
                                        <a class="btn-card btn-card-small btn-gray" href="<?=Url::toRoute(['/vacancy/search', 'category_ids' => json_encode([$vacancy->category[0]->id])])?>"><?=$vacancy->category[0]->name?></a>
                                    </div>
                                    <?php endif ?>
                                    <a class="last-vacancy__title" href="/vacancy/view/<?= $vacancy->id ?>" title="$vacancy->post"><?=$vacancy->post?></a>
                                </div>
                            </div>
                            <div class="last-vacancy__info">
                                <p>
                                    <?=StringHelper::truncate($vacancy->responsibilities, 200, '...')?>
                                </p>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </aside>
            <div class="last-vacancy mob-last-vacancy">
                <h2 class="last-vacancy__head">Последние вакансии
                </h2>
                <?php foreach ($last_vacancies as $vacancy):?>
                    <div class="last-vacancy__item">
                        <div class="last-vacancy__tr">
                        </div>
                        <div class="last-vacancy__header"><img src="<?=$vacancy->company->getPhotoOrEmptyPhoto()?>" alt="" role="presentation"/>
                            <div class="last-vacancy__top">
                                <?php if($vacancy->category):?>
                                    <div class="last-vacancy__cat-city">
                                        <a class="btn-card btn-card-small btn-gray" href="<?=Url::toRoute(['/vacancy/search', 'category_ids' => json_encode([$vacancy->category[0]->id])])?>"><?=$vacancy->category[0]->name?></a>
                                    </div>
                                <?php endif ?>
                                <a class="last-vacancy__title" href="/vacancy/view/<?= $vacancy->id ?>" title="$vacancy->post"><?=$vacancy->post?></a>
                            </div>
                        </div>
                        <div class="last-vacancy__info">
                            <p>
                                <?=StringHelper::truncate($vacancy->responsibilities, 200, '...')?>
                            </p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</section>