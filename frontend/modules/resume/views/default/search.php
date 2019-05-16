<?php
/* @var $this View */
/* @var $categories Category[] */
/* @var $resumes \yii\data\ActiveDataProvider */
/* @var $employment_types \common\models\EmploymentType[] */
/* @var $city string */
/* @var $search_text string */
/* @var $experience_ids array */

/* @var $cities \common\models\City[] */

use common\models\Category;
use common\models\Experience;
use common\models\KeyValue;
use common\models\Resume;
use frontend\assets\MainAsset;
use yii\web\View;
use yii\widgets\LinkPager;

$this->title=KeyValue::findValueByKey('resume_search_page_title')?:"Поиск резюме";
$this->registerMetaTag(['description' => KeyValue::findValueByKey('resume_search_page_description')]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/resume_search.js', ['depends' => [MainAsset::className()]]);
?>

<section class="all-block all-resume"><img class="all-block__dots2" src="/images/bg-dots.png" alt=""
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
                                                    role="presentation"/><img class="logo__info" src="/images/ico-i.png"
                                                                              alt="" role="presentation"/>
                        </div>
                        <span class="logo__text">Актуальных вакансий сейчас</span>
                    </div>
                    <div class="search"><input type="text" placeholder="Поиск" name="resume_search_text"
                                               <?php if (isset($search_text)): ?>value="<?= $search_text ?>"<?php endif ?>/>
                        <button id="search" class="btn-red"><i class="fa fa-search"></i>
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
                            <select class="vl-block__cities jsCitiesSelect">
                                <option></option>
                                <?php foreach ($cities as $sel_city): ?>
                                    <option <?= $sel_city->name == $city ? 'selected' : '' ?>><?= $sel_city->name ?></option>
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
                                           name="experience" data-id="0"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?= in_array(0, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                    />
                                    <div class="checkbox__text">Не имеет значения
                                    </div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"
                                           name="experience" data-id="1"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?= in_array(1, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                    />
                                    <div class="checkbox__text">Менее года
                                    </div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"
                                           name="experience" data-id="2"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?= in_array(2, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                    />
                                    <div class="checkbox__text">1 год
                                    </div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"
                                           name="experience" data-id="3"
                                        <?php if(isset($experience_ids) && $experience_ids !== []): ?>
                                            <?= in_array(3, $experience_ids)?'checked':''?>
                                        <?php endif ?>
                                    />
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
                                            <?php if (isset($category_ids) && $category_ids !== []): ?>
                                                <?= in_array($category->id, $category_ids) ? 'checked' : '' ?>
                                            <?php endif ?>
                                               name="category" data-id="<?= $category->id ?>"/>
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
                                            <?php if (isset($employment_type_ids) && $employment_type_ids !== []): ?>
                                                <?= in_array($employment_type->id, $employment_type_ids) ? 'checked' : '' ?>
                                            <?php endif ?>
                                               name="employment_type" data-id="<?= $employment_type->id ?>"/>
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
                                <input type="text" name="min_salary"
                                       value="<?= isset($min_salary) ? $min_salary : '' ?>"/>
                                <input type="text" name="max_salary"
                                       value="<?= isset($max_salary) ? $max_salary : '' ?>"/>
                            </div>
                        </div>
                        <button class="vl-btn btn-card btn-red" id="accept">Применить
                        </button>
                    </div>
                </div>
                <div class="v-content-bottom__center">
                    <?php /** @var Resume $resume */
                    if ($resumes->models):
                        foreach ($resumes->models as $resume):?>
                            <div class="single-card-resume">
                                <div class="single-card-resume__top"><img class="single-card-resume__left-img"
                                                                          src="<?= $resume->image_url ?>" alt=""
                                                                          role="presentation"/>
                                    <div class="single-card-resume__top-left">
                                        <div class="single-card-resume__head">
                                            <h3><a href="/resume/view/<?= $resume->id ?>"><?= $resume->title ?></a></h3>
                                            <!--                                    <p class="single-card-resume__status vr-head">Онлайн-->
                                            <!--                                    </p>-->
                                        </div>
                                        <span class="single-card-resume__price"><?= $resume->min_salary ?>-<?= $resume->max_salary ?> RUB</span>
                                        <p class="single-card-resume__name"><?= $resume->employer->second_name ?> <?= $resume->employer->first_name ?>
                                            · возраст - <?= $resume->employer->age ?> · <?= $resume->city ?>
                                        </p>
                                        <?php if($resume->employment_type): ?>
                                        <p class="single-card-resume__employment"><?= $resume->employment_type->name ?>
                                        </p>
                                        <?php endif ?>
                                        <p class="single-card-resume__last-work">Последнее место работы
                                        </p>
                                        <p class="single-card-resume__name-work"><?= $resume->lastExperience->post ?>
                                            , <?= $resume->lastExperience->name ?>
                                        </p>
                                        <p class="single-card-resume__date-work"><?= Experience::$months[$resume->lastExperience->month_from] ?> <?= $resume->lastExperience->year_from ?>
                                            — <?= Experience::$months[$resume->lastExperience->month_to] ?> <?= $resume->lastExperience->year_to ?>
                                        </p>
                                        <p class="single-card-resume__last-check">
                                            Обновлено <?= date('d.m.Y', $resume->update_time) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="single-card-resume__bottom">
                                    <?php if ($resume->hasSocials()): ?>
                                        <div class="single-card-resume__soc">
                                            <p>Написать соискателю в сетях
                                            </p>
                                            <div class="single-card-resume__soc-block">
                                                <?php if ($resume->vk): ?>
                                                    <a class="vk-bg" target="_blank" href="<?= $resume->vk ?>"><img src="/images/vk.svg"
                                                                                                    alt=""
                                                                                                    role="presentation"/></a>
                                                <?php endif ?>
                                                <?php if ($resume->facebook): ?>
                                                    <a class="fb-bg" target="_blank" href="<?= $resume->facebook ?>"><img
                                                                src="/images/fb.svg" alt="" role="presentation"/></a>
                                                <?php endif ?>
                                                <?php if ($resume->instagram): ?>
                                                    <a class="inst-bg" target="_blank" href="<?= $resume->instagram ?>"><img
                                                                src="/images/instagram.svg" alt="" role="presentation"/></a>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <?= LinkPager::widget([
                        'pagination' => $resumes->pagination,
                        'options' => ['class' => 'search-pagination'],
                        'maxButtonCount' => 5,
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'nextPageLabel' => '>',
                        'prevPageLabel' => '<',
                    ]); ?>
                    <?php else: ?>
                        <div class="single-card-resume">
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
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="vr-card">-->
                <!--                            <div class="vr-card__head">-->
                <!--                                <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt="" role="presentation"/>-->
                <!--                                </div>-->
                <!--                                <div class="vr-card__name-time">-->
                <!--                                    <p class="vr-card__name">Дмитрий Иванов-->
                <!--                                    </p><span class="vr-card__time">2 минуты назад</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <p class="vr-card__text">-->
                <!--                                Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
                <!--                            </p>-->
                <!--                            <div class="vr-card__bottom"><span><img src="/images/like.svg" alt="" role="presentation"/>Нравится 96</span><span><img src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
</section>