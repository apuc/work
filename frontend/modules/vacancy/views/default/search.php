<?php

/* @var $this View */
/* @var $categories Category[] */
/* @var $tags \common\models\Skill[] */
/* @var $vacancies \yii\data\ActiveDataProvider */
/* @var $category_ids array */
/* @var $tags_id array */
/* @var $experience_ids array */
/* @var $employment_type_ids array */
/* @var $min_salary int */
/* @var $max_salary int */
/* @var $search_text string */
/* @var $city \common\models\City */
/* @var $current_category Category|null */

/* @var $employment_types EmploymentType[] */
/* @var $cities City[] */

use common\classes\MoneyFormat;
use common\models\Category;
use common\models\EmploymentType;
use common\models\KeyValue;
use common\models\Vacancy;
use frontend\assets\MainAsset;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

$meta_data = Vacancy::getMetaData($city, $current_category);
$this->title = $meta_data['title'];
$this->registerMetaTag(['name'=>'description', 'content' => $meta_data['description']]);
$this->registerMetaTag(['name'=>'og:title', 'content' => $this->title]);
$this->registerMetaTag(['name'=>'og:type', 'content' => 'website']);
$this->registerMetaTag(['name'=>'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name'=>'og:image', 'content' => Yii::$app->urlManager->hostInfo.'/images//og_image.jpg']);
$this->registerMetaTag(['name'=>'og:description', 'content' => $meta_data['description']]);

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/vacancy_search.js', ['depends' => [MainAsset::className()]]);
?>
<section class="all-block all-vacancies">
    <img class="all-block__dots2" src="/images/bg-dots.png" alt="" role="presentation"/>
    <div class="all-block__circle">
    </div>
    <div class="all-block__content">
        <button class="filter-btn jsShowFilter">Фильтр</button>
        <div class="container">
            <div class="v-content-top">
                <div class="home__aside-header">
                    <h1 class="resume__title"><?=$meta_data['header']?></h1>
                    <div class="search">
                        <input type="text" name="vacancy_search_text" placeholder="Поиск" value="<?=$search_text?>"/>
                        <button class="btn-red" id="search">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="v-content-bottom container-for-sidebar">
                <div class="filter-overlay jsFilterOverlay">
                </div>
                <div class="v-content-bottom__left sidebar jsOpenFilter" id="sidebar">
                    <div class="filter-close jsHideFilter"><span></span><span></span>
                    </div>
                    <div class="sidebar-inner">
                        <div class="vl-block">
                            <select class="vl-block__cities jsDutiesSelect" multiple="multiple">
                                <option></option>
                                <?php foreach($tags as $tag):?>
                                    <option value="<?=$tag->id?>"
                                        <?php if(is_array($tags_id)):?>
                                            <?=in_array($tag->id, $tags_id)?'selected':""?>
                                        <?php endif?>
                                    ><?=$tag->name?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="vl-block">
                            <select class="vl-block__cities jsCitiesSelect">
                                <option></option>
                                <?php $city_id = $city?$city->id:null;?>
                                <?php foreach($cities as $sel_city):?>
                                <option <?=$sel_city->id == $city_id?'selected':''?> value="<?=$sel_city->slug?>"><?=$sel_city->name?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Требуемый опыт
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">
                                <?php foreach (Vacancy::$experiences as $key => $experience):?>
                                <label class="checkbox">
                                    <input type="checkbox"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?=in_array($key, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                           name="experience" data-id="<?=$key?>"/>
                                    <div class="checkbox__text"><?=$experience?>
                                    </div>
                                </label>
                                <?php endforeach ?>
<!--                                <label class="checkbox">-->
<!--                                    <input type="checkbox"-->
<!--                                        --><?php //if(isset($experience_ids) && $experience_ids !== []): ?>
<!--                                            --><?//=in_array(0, $experience_ids)?'checked':''?>
<!--                                        --><?php //endif ?>
<!--                                           name="experience" data-id="0"/>-->
<!--                                    <div class="checkbox__text">Без опыта работы-->
<!--                                    </div>-->
<!--                                </label>-->
<!--                                <label class="checkbox">-->
<!--                                    <input type="checkbox"-->
<!--                                        --><?php //if(isset($experience_ids) && $experience_ids !== []): ?>
<!--                                            --><?//=in_array(1, $experience_ids)?'checked':''?>
<!--                                        --><?php //endif ?>
<!--                                           name="experience" data-id="1"/>-->
<!--                                    <div class="checkbox__text">От 1 года-->
<!--                                    </div>-->
<!--                                </label>-->
<!--                                <label class="checkbox">-->
<!--                                    <input type="checkbox"-->
<!--                                        --><?php //if(isset($experience_ids) && $experience_ids !== []): ?>
<!--                                            --><?//=in_array(2, $experience_ids)?'checked':''?>
<!--                                        --><?php //endif ?>
<!--                                           name="experience" data-id="2"/>-->
<!--                                    <div class="checkbox__text">От 3 лет-->
<!--                                    </div>-->
<!--                                </label>-->
<!--                                <label class="checkbox">-->
<!--                                    <input type="checkbox"-->
<!--                                        --><?php //if(isset($experience_ids) && $experience_ids !== []): ?>
<!--                                            --><?//=in_array(3, $experience_ids)?'checked':''?>
<!--                                        --><?php //endif ?>
<!--                                           name="experience" data-id="3"/>-->
<!--                                    <div class="checkbox__text">От 5 лет-->
<!--                                    </div>-->
<!--                                </label>-->
                            </div>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Категория</p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">
                                <?php foreach ($categories as $category): ?>
                                    <label class="checkbox">
                                        <input type="checkbox"
                                            <?php if(isset($category_ids) && $category_ids !== []): ?>
                                            <?=in_array($category->id, $category_ids)?'checked':''?>
                                            <?php endif ?>
                                            name="category" data-slug="<?=$category->slug?>" data-id="<?=$category->id?>"/>
                                        <div class="checkbox__text"><?= $category->name ?></div>
                                    </label>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Вид занятости</p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">
                                <?php foreach ($employment_types as $employment_type): ?>
                                    <label class="checkbox">
                                        <input type="checkbox"
                                            <?php if(isset($employment_type_ids) && $employment_type_ids !== []): ?>
                                                <?=in_array($employment_type->id, $employment_type_ids)?'checked':''?>
                                            <?php endif ?>
                                               name="employment_type" data-id="<?=$employment_type->id?>"/>
                                        <div class="checkbox__text"><?= $employment_type->name ?></div>
                                    </label>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="vl-block no-border">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Зарплата
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__inputs jsCheckBlock">
                                <input type="text" name="min_salary" value="<?=isset($min_salary)?$min_salary:''?>" />
                                <input type="text" name="max_salary" value="<?=isset($max_salary)?$max_salary:''?>" />
                            </div>
                        </div>
                        <button class="vl-btn btn-card btn-red" id = "accept">Применить</button>
                    </div>
                </div>
                <div class="v-content-bottom__center scroll">
                    <?php if(!$vacancies): ?>
                    <div class="single-card">
                        <p>Нет результатов поиска</p>
                    </div>
                    <?php endif ?>
                    <?php if($vacancies->models):
                        foreach ($vacancies->models as $vacancy): ?>
                        <?php /** @var Vacancy $vacancy */ ?>
                        <div class="single-card">
                            <div class="single-card__tr">
                            </div>
                            <div class="single-card__header">
                                <?php foreach ($vacancy->category as $category): ?>
                                    <a class="btn-card btn-card-small btn-gray" href="<?=Vacancy::getSearchPageUrl($category->slug)?>"><?= $category->name ?></a>
                                <?php endforeach ?>
                                <img class="single-card__image" src="<?=$vacancy->company->getPhotoOrEmptyPhoto()?>" alt="" role="presentation"/>
                            </div>
                            <?php if($category_ids && count($category_ids) === 1):?>
                                <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id, 'referer_category'=>$category_ids[0]])?>" class="single-card__title mt5">
                                    <?= ucfirst($vacancy->post) ?>
                                </a>
                            <?php else: ?>
                                <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="single-card__title mt5">
                                    <?= ucfirst($vacancy->post) ?>
                                </a>
                            <?php endif ?>
                            <div class="single-card__info-second"><span
                                        class="mr10">Добавлено: <?= Yii::$app->formatter->asDate($vacancy->update_time, 'dd.MM.yyyy') ?></span>
                                <div class="single-card__view"><img class="single-card__icon mr5"
                                                                    src="/images/icon-eye.png" alt=""
                                                                    role="presentation"/><span><?= $vacancy->countViews ?></span>
                                </div>
                                <a class="d-flex align-items-center mt5 mb5" href="<?=Vacancy::getSearchPageUrl(false, $vacancy->city0?$vacancy->city0->slug:false)?>">
                                    <img class="single-card__icon" src="/images/arr-place.png" alt="" role="presentation"/>
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
                                        <a target="_blank" class="vk-bg" rel="nofollow" href="https://vk.com/<?=$vacancy->company->vk?>"><img src="/images/vk.svg" alt="" role="presentation"/></a>
                                        <?php endif ?>
                                        <?php if($vacancy->company->instagram):?>
                                        <a target="_blank" class="ok-bg" rel="nofollow" href="https://instagram.com/<?=$vacancy->company->instagram?>"><img src="/images/ok.svg" alt="" role="presentation"/></a>
                                        <?php endif ?>
                                        <?php if($vacancy->company->facebook):?>
                                        <a target="_blank" class="fb-bg" rel="nofollow" href="https://facebook.com/<?=$vacancy->company->facebook?>"><img src="/images/fb.svg" alt="" role="presentation"/></a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                                <?php if($category_ids && count($category_ids) === 1):?>
                                    <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id, 'referer_category'=>$category_ids[0]])?>" class="btn-card btn-red">
                                        Посмотреть полностью
                                    </a>
                                <?php else: ?>
                                    <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>" class="btn-card btn-red">
                                        Посмотреть полностью
                                    </a>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                     <?= LinkPager::widget([
                         'pagination' => $vacancies->pagination,
                         'options' => ['class' => 'search-pagination'],
                         'maxButtonCount' => 5,
                         'nextPageLabel' => 'Вперед',
                         'prevPageLabel' => 'Назад',
                     ]);?>
                    <?php else: ?>
                        <div class="single-card">
                            <p>К сожалению по заданным критериям вакансии не найдены. Разместите свое резюме на сайте и работодатели позвонят Вам!</p>
                            <a class="btn btn-red create__resume__button" href="/personal-area/add-resume">разместить резюме</a>
                        </div>
                    <?php endif ?>
                    <?php if($city && $current_category):?>
                        <p class="bottom__center-text">
                            Вакансии в <?=$city->prepositional?> из категории - <?=$category->name?>.
                            Ищите работу в <?=$city->prepositional?>, выберите вакансию и отправьте свое резюме!
                            На странице вакансии Вы так же найдете контактный телефон работодателя и Email.
                            Если Вы не нашли интересующую вакансию в категории <?=$category->name?>
                            в <?=$city->prepositional?>, разместите резюме в категорию - <?=$category->name?>,
                            при добавлении резюме укажите город поиска работы, например <?=$city->name?>.
                        </p>
                    <?php elseif($city && $city->bottom_text):?>
                        <p class="bottom__center-text"><?=$city->bottom_text?></p>
                    <?php elseif ($current_category && $current_category->metaData): ?>
                        <p class="bottom__center-text"><?=$current_category->metaData->vacancy_bottom_text?></p>
                    <?php endif; ?>

                </div>
<!--                <div class="soc-sidebar" id="sidebar-vr">-->
<!--                    <div class="sidebar-inner">-->
<!--                        <p class="vr-head">Прямой эфир-->
<!--                        </p>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="vr-card">-->
<!--                            <div class="vr-card__head">-->
<!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                                      role="presentation"/>-->
<!--                                </div>-->
<!--                                <div class="vr-card__name-time">-->
<!--                                    <p class="vr-card__name">Дмитрий Иванов-->
<!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <p class="vr-card__text">-->
<!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в-->
<!--                                Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                            </p>-->
<!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                                    role="presentation"/>Нравится 96</span><span><img-->
<!--                                            src="/images/chat.svg" alt=""-->
<!--                                            role="presentation"/>Комментировать 5</span><span><img-->
<!--                                            src="/images/speaker-side-view.svg" alt=""-->
<!--                                            role="presentation"/>4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</section>