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
/* @var $city string */

/* @var $employment_types EmploymentType[] */
/* @var $cities City[] */

use common\models\Category;
use common\models\EmploymentType;
use common\models\KeyValue;
use common\models\Vacancy;
use frontend\assets\MainAsset;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

$city_model=\common\models\City::find()->where(['name'=>$city])->one();
if($city_model && $search_text){
    $this->title="Работа в $city_model->prepositional: $search_text";
} else if($city_model) {
    $this->title="Работа в $city_model->prepositional";
} else if($search_text) {
    $this->title="Поиск работы: $search_text";
} else {
    $this->title=KeyValue::findValueByKey('vacancy_search_page_title')?:"Поиск Вакансий";
}

$this->registerMetaTag(['name'=>'description', 'content' => KeyValue::findValueByKey('vacancy_search_page_description')]);
$this->registerMetaTag(['name'=>'og:title', 'content' => $this->title]);
$this->registerMetaTag(['name'=>'og:type', 'content' => 'website']);
$this->registerMetaTag(['name'=>'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name'=>'og:image', 'content' => Yii::$app->urlManager->hostInfo.'/images/logo-main.png']);
$this->registerMetaTag(['name'=>'og:description', 'content' => KeyValue::findValueByKey('vacancy_search_page_description')]);

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/vacancy_search.js', ['depends' => [MainAsset::className()]]);
?>
<section class="all-block all-vacancies"><img class="all-block__dots2" src="/images/bg-dots.png" alt=""
                                    role="presentation"/>
    <div class="all-block__circle">
    </div>
    <div class="all-block__content">
        <button class="filter-btn jsShowFilter">Фильтр
        </button>
        <div class="container">
            <div class="v-content-top">
                <div class="home__aside-header">
                    <div class="logo">
                        <div class="logo__img"><img class="logo__main" src="/images/logo.png" alt=""
                                                    role="presentation"/><img class="logo__info"
                                                                              src="/images/ico-i.png" alt=""
                                                                              role="presentation"/>
                        </div>
                        <span class="logo__text">Актуальных вакансий сейчас</span>
                    </div>
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
                                <?php foreach($cities as $sel_city):?>
                                <option <?=$sel_city->name == $city?'selected':''?>><?=$sel_city->name?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Требуемый опыт
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">
                                <label class="checkbox">
                                    <input type="checkbox"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?=in_array(0, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                           name="experience" data-id="0"/>
                                    <div class="checkbox__text">Не имеет значения
                                    </div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?=in_array(1, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                           name="experience" data-id="1"/>
                                    <div class="checkbox__text">Менее года
                                    </div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?=in_array(2, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                           name="experience" data-id="2"/>
                                    <div class="checkbox__text">1 год
                                    </div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?=in_array(3, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                           name="experience" data-id="3"/>
                                    <div class="checkbox__text">2 года
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Категория
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">
                                <?php foreach ($categories as $category): ?>
                                    <label class="checkbox">
                                        <input type="checkbox"
                                            <?php if(isset($category_ids) && $category_ids !== []): ?>
                                            <?=in_array($category->id, $category_ids)?'checked':''?>
                                            <?php endif ?>
                                               name="category" data-id="<?=$category->id?>"/>
                                        <div class="checkbox__text"><?= $category->name ?></div>
                                    </label>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Вид занятости
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
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
                        <button class="vl-btn btn-card btn-red" id = "accept">Применить
                        </button>
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
                                    <a class="btn-card btn-card-small btn-gray" href="<?=Url::toRoute(['/vacancy/search', 'category_ids' => json_encode([$category->id])])?>"><?= $category->name ?></a>
                                <?php endforeach ?>
                                <img
                                        class="single-card__image" src="<?=$vacancy->company->getPhotoOrEmptyPhoto()?>" alt=""
                                        role="presentation"/>
                            </div>
                            <h3 class="single-card__title mt5"><?= $vacancy->post ?></h3>
                            <div class="single-card__info-second"><span
                                        class="mr10">Добавлено: <?= Yii::$app->formatter->asDate($vacancy->created_at, 'dd.MM.yyyy') ?></span>
                                <div class="single-card__view"><img class="single-card__icon mr5"
                                                                    src="/images/icon-eye.png" alt=""
                                                                    role="presentation"/><span><?= $vacancy->views ?></span>
                                </div>
                                <a class="d-flex align-items-center mt5 mb5" href="<?=Url::toRoute(["/vacancy/search/город:$vacancy->city"])?>"><img
                                            class="single-card__icon"
                                            src="/images/arr-place.png"
                                            alt=""
                                            role="presentation"/><span
                                            class="ml5"><?= $vacancy->city ?></span></a>
                            </div>
                            <span class="single-card__price">
                                <?php if($vacancy->min_salary && $vacancy->max_salary):?>
                                    <?= $vacancy->min_salary ?>-<?= $vacancy->max_salary ?> RUB
                                <?php elseif ($vacancy->min_salary):?>
                                    От <?= $vacancy->min_salary ?> RUB
                                <?php elseif ($vacancy->max_salary):?>
                                    До <?= $vacancy->max_salary ?> RUB
                                <?php else: ?>
                                    Зарплата договорная
                                <?php endif?>
                    </span>
                            </span>
                            <div class="single-card__info">
                                <p><?= nl2br(StringHelper::truncate($vacancy->responsibilities, 80, '...')) ?></p>
                            </div>
                            <div class="single-card__bottom">
                                <div class="single-card__info__soc">
                                    <?php if($vacancy->company->hasSocials()): ?>
                                        <span>Написать соискателю в сетях</span>
                                        <?php if($vacancy->company->vk):?>
                                        <a target="_blank" class="vk-bg" href="<?=$vacancy->company->vk?>"><img src="/images/vk.svg" alt="" role="presentation"/></a>
                                        <?php endif ?>
                                        <?php if($vacancy->company->instagram):?>
                                        <a target="_blank" class="ok-bg" href="<?=$vacancy->company->instagram?>"><img src="/images/ok.svg" alt="" role="presentation"/></a>
                                        <?php endif ?>
                                        <?php if($vacancy->company->facebook):?>
                                        <a target="_blank" class="fb-bg" href="<?=$vacancy->company->facebook?>"><img src="/images/fb.svg" alt="" role="presentation"/></a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                                <a class="btn-card btn-red" href="/vacancy/view/<?= $vacancy->id ?>">Посмотреть
                                    полностью</a>
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
                            <p>По вашему запросу не найдено результатов.</p>
                        </div>
                    <?php endif ?>

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