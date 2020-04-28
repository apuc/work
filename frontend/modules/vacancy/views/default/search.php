<?php

/* @var $this View */
/* @var $searchModel \frontend\modules\vacancy\classes\VacancySearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $cities City[] */
/* @var $categories Category[] */
/* @var $employment_types EmploymentType[] */
/* @var $countries \common\models\Country[] */
/* @var $canonical_rel string */

use common\classes\MoneyFormat;
use common\models\Category;
use common\models\City;
use common\models\EmploymentType;
use common\models\Vacancy;
use frontend\assets\MainAsset;
use frontend\modules\vacancy\classes\VacancyMetaFormer;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

VacancyMetaFormer::registerVacancySearchPageTags($this, $searchModel->current_city, $searchModel->current_category, $searchModel->current_profession, $searchModel->current_country);
$this->registerLinkTag(['rel'=>'canonical', 'href'=>$canonical_rel]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/vacancy_search.min.js', ['depends' => [MainAsset::className()]]);
?>
<section class="all-block all-vacancies">
    <img class="all-block__dots2" src="/images/bg-dots.png" alt="Точки" role="presentation"/>
    <div class="all-block__circle">
    </div>
    <div class="all-block__content">
        <button class="filter-btn jsShowFilter">Фильтр</button>
        <div class="container">
            <div class="v-content-top">
                <div class="home__aside-header">
                    <h1 class="resume__title"><?=VacancyMetaFormer::getSearchPageHeader($searchModel->current_city, $searchModel->current_category, $searchModel->current_profession, $searchModel->current_country)?></h1>
                    <div class="search">
                        <input type="text" name="vacancy_search_text" placeholder="Поиск" value="<?=$searchModel->search_text?>"/>
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
                    <button class="vl-btn btn-card btn-red jsAccept btn-accept jsAcceptScrollFixed">Применить</button>
                    <div class="filter-close jsHideFilter"><span></span><span></span>
                    </div>
                    <div class="sidebar-inner">
                        <div class="vl-block">
                            <select class="vl-block__cities jsCountriesSelect">
                                <option></option>
                                <?php if ($searchModel->current_country)
                                    $country_id = $searchModel->current_country->id;
                                else if ($searchModel->current_city)
                                    $country_id = $searchModel->current_city->region->country_id;
                                else
                                    $country_id = null; ?>
                                <?php foreach($countries as $country):?>
                                    <option <?=$country->id == $country_id?'selected':''?> value="<?=$country->slug?>"><?=$country->name?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="vl-block cities-select-block<?=$cities?'':' hide'?>">
                            <select class="vl-block__cities jsCitiesSelect">
                                <option></option>
                                <?php if($cities): ?>
                                    <?php $city_id = $searchModel->current_city?$searchModel->current_city->id:null;?>
                                    <?php foreach($cities as $city):?>
                                    <option <?=$city->id == $city_id?'selected':''?> value="<?=$city->slug?>"><?=$city->name?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
                                        <?php if(isset($searchModel->experience_ids) && $searchModel->experience_ids !== []): ?>
                                            <?=in_array($key, $searchModel->experience_ids)?'checked':''?>
                                        <?php endif ?>
                                           name="experience" data-id="<?=$key?>"/>
                                    <div class="checkbox__text"><?=$experience?>
                                    </div>
                                </label>
                                <?php endforeach ?>
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
                                            <?php if(isset($searchModel->category_ids) && $searchModel->category_ids !== []): ?>
                                            <?=in_array($category->id, $searchModel->category_ids)?'checked':''?>
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
                                            <?php if(isset($searchModel->employment_type_ids) && $searchModel->employment_type_ids !== []): ?>
                                                <?=in_array($employment_type->id, $searchModel->employment_type_ids)?'checked':''?>
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
                                <input type="text" name="min_salary" value="<?=isset($searchModel->min_salary)?$searchModel->min_salary:''?>" />
                                <input type="text" name="max_salary" value="<?=isset($searchModel->max_salary)?$searchModel->max_salary:''?>" />
                            </div>
                        </div>
                        <button class="vl-btn btn-card btn-red jsAccept jsAcceptScroll">Применить</button>
                    </div>
                </div>
                <div class="v-content-bottom__center scroll">
                    <?php if(!$dataProvider): ?>
                    <div class="single-card">
                        <p>Нет результатов поиска</p>
                    </div>
                    <?php endif ?>
                    <?php if($dataProvider->models):
                        foreach ($dataProvider->models as $vacancy): ?>
                        <?php /** @var Vacancy $vacancy */ ?>
                        <div class="single-card">
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
                            <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id, 'referer_category'=>$vacancy->main_category_id])?>" class="single-card__title mt5">
                                <?= mb_convert_case ( $vacancy->post , MB_CASE_TITLE) ?>
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
                                    <a href="<?=Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id, 'referer_category'=>$searchModel->category_ids[0]])?>" class="btn-card btn-red">
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
                         'pagination' => $dataProvider->pagination,
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
                    <?php if($searchModel->current_city && $searchModel->current_category):?>
                        <p class="bottom__center-text">
                            Вакансии в <?=$searchModel->current_city->prepositional?> из категории - <?=$searchModel->current_category->name?>.
                            Ищите работу в <?=$searchModel->current_city->prepositional?>, выберите вакансию и отправьте свое резюме!
                            На странице вакансии Вы так же найдете контактный телефон работодателя и Email.
                            Если Вы не нашли интересующую вакансию в категории <?=$searchModel->current_category->name?>
                            в <?=$searchModel->current_city->prepositional?>, разместите резюме в категорию - <?=$searchModel->current_category->name?>,
                            при добавлении резюме укажите город поиска работы, например <?=$searchModel->current_city->name?>.
                        </p>
                    <?php elseif($searchModel->current_city && $searchModel->current_profession):?>
                        <p class="bottom__center-text">
                            Вакансии в <?=$searchModel->current_city->prepositional?> по запросу - <?=$searchModel->current_profession->title?>.
                            Свежие вакансии <?=$searchModel->current_profession->genitive?> в <?=$searchModel->current_city->prepositional?>.
                            Выбирайте работу и отправляйте резюме! Так же на странице вакансии
                            Вы найдете контактный телефон работодателя.
                            Если вы на нашлий подходящую вакансию <?=$searchModel->current_profession->genitive?> в <?=$searchModel->current_city->prepositional?>,
                            разместите свое резюме на сайте и работодатели свяжуться с Вами!
                            Сайт поиска работы №1 в <?=$searchModel->current_city->region->name?>!
                        </p>
                    <?php elseif($searchModel->current_profession && $searchModel->current_profession->metaData):?>
                        <p class="bottom__center-text"><?=$searchModel->current_profession->metaData->vacancy_bottom_text?></p>
                    <?php elseif($searchModel->current_city && $searchModel->current_city->bottom_text):?>
                        <p class="bottom__center-text"><?=$searchModel->current_city->bottom_text?></p>
                    <?php elseif ($searchModel->current_category && $searchModel->current_category->metaData): ?>
                        <p class="bottom__center-text"><?=$searchModel->current_category->metaData->vacancy_bottom_text?></p>
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