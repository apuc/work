<?php

/* @var $this View */
/* @var $searchModel \frontend\modules\vacancy\classes\VacancySearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $cities City[] */
/* @var $anchored_vacancies Vacancy[] */
/* @var $categories Category[] */
/* @var $employment_types EmploymentType[] */
/* @var $countries \common\models\Country[] */
/* @var $canonical_rel string */

use common\classes\MoneyFormat;
use common\helpers\StringHelper;
use common\models\Category;
use common\models\City;
use common\models\EmploymentType;
use common\models\Vacancy;
use frontend\assets\MainAsset;
use frontend\modules\vacancy\classes\VacancyMetaFormer;
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
<!---->
<!--                    <div class="banner-subscription">-->
<!--                        <img src="/images/banner_image.png" alt="">-->
<!--                        <div class="banner-subscription__right">-->
<!--                            <h3>Подписка на новые вакансии</h3>-->
<!--                            <div class="banner-subscription__right-bottom">-->
<!--                                <a href="#" class="btn-card btn-red">-->
<!--                                    Подписаться-->
<!--                                </a>-->
<!--                                <p>-->
<!--                                    Подписка позволяет <span>отслеживать-->
<!--                                    новые вакансии</span> по соответствующим-->
<!--                                    условиям на сайте иили получать-->
<!--                                    их по электронной почте-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="banner-subscription2">-->
<!--                        <h3>Получай <span>свежие вакансии</span> по выбранным условиям!</h3>-->
<!--                        <p>Получай <span>новые вакансии</span> по соответствующим условиям по электронной почте каждый день</p>-->
<!--                        <form action="">-->
<!--                            <input type="email" placeholder="Email">-->
<!--                            <button class="btn-card btn-red">Подписаться</button>-->
<!--                        </form>-->
<!--                    </div>-->
<!---->

                    <?php if (!empty($anchored_vacancies)):
                    $random_key = rand(4, 9);
                    $i = 0;
                    foreach ($anchored_vacancies as $key => $vacancy): ?>

                        <?php
                        $i++;
                        /** @var Vacancy $vacancy */
                        $flag = (
                            $vacancy->company->user->email === "rabotavdnr@mail.ru"
                            && !Yii::$app->user->isguest
                            && Yii::$app->user->identity->email === "test@test.test"
                        )
                        ?>
                        <?= $vacancy->day_vacancy_until > time()
                            ? $this->render('/parts/_vacancy_day', compact('vacancy'))
                            : $this->render('/parts/_vacancy_standart', compact(['vacancy', 'flag', 'searchModel']))
                        ?>

                        <?= ($key === $random_key) ?
                            \frontend\widgets\Banner::widget([
                                'categoryId' => $searchModel->current_category ? $searchModel->current_category->id : null,
                                'cityId' => $searchModel->current_city ? $searchModel->current_city->id : null,
                            ]) : '';
                        ?>
                    <?php endforeach; endif;?>


                    <?php if($dataProvider->models):
                        $random_key = rand(4, 9);
                        $i = 0;
                        foreach ($dataProvider->models as $key => $vacancy): ?>

                        <?php
                            $i++;
                            /** @var Vacancy $vacancy */
                            $flag = (
                                    $vacancy->company->user->email === "rabotavdnr@mail.ru"
                                    && !Yii::$app->user->isguest
                                    && Yii::$app->user->identity->email === "test@test.test"
                            )
                        ?>
                            <?= $vacancy->day_vacancy_until > time()
                                ? $this->render('/parts/_vacancy_day', compact('vacancy'))
                                : $this->render('/parts/_vacancy_standart', compact(['vacancy', 'flag', 'searchModel']))
                            ?>

                            <?= ($key === $random_key) ?
                                \frontend\widgets\Banner::widget([
                                    'categoryId' => $searchModel->current_category ? $searchModel->current_category->id : null,
                                    'cityId' => $searchModel->current_city ? $searchModel->current_city->id : null,
                                ]) : '';
                            ?>
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
            </div>
        </div>
    </div>
</section>