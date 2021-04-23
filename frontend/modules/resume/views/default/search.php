<?php
/* @var $this View */
/* @var $searchModel \frontend\modules\resume\classes\ResumeSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $categories Category[] */
/* @var $tags_id array */
/* @var $tags \common\models\Skill[] */
/* @var $resumes \yii\data\ActiveDataProvider */
/* @var $employment_types \common\models\EmploymentType[] */
/* @var $city \common\models\City */
/* @var $experience_ids array */
/* @var $current_category Category|null */
/* @var $canonical_rel string */

/* @var $cities \common\models\City[] */

use common\classes\MoneyFormat;
use common\models\Category;
use common\models\Experience;
use common\models\KeyValue;
use common\models\Resume;
use frontend\assets\MainAsset;
use frontend\modules\resume\classes\ResumeMetaFormer;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

ResumeMetaFormer::registerResumeSearchPageTags($this, $searchModel->current_city, $searchModel->current_category, $searchModel->current_profession);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/resume_search.js', ['depends' => [MainAsset::className()]]);
?>

<section class="all-block all-resume">
    <img class="all-block__dots2" src="/images/bg-dots.png" alt="Точки" role="presentation"/>
    <div class="all-block__circle">
    </div>
    <div class="all-block__content">
        <button class="filter-btn jsShowFilter">Фильтр
        </button>
        <div class="container">
            <div class="v-content-top">
                <div class="home__aside-header">
                    <h1 class="resume__title"><?=ResumeMetaFormer::getSearchPageHeader($searchModel->current_city, $searchModel->current_category, $searchModel->current_profession)?></h1>
                    <div class="search"><input type="text" placeholder="Поиск" name="resume_search_text"
                                               <?php if (isset($searchModel->search_text)): ?>value="<?= $searchModel->search_text ?>"<?php endif ?>/>
                        <button id="search" class="btn-red"><i class="fa fa-search"></i>
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
                            <select class="vl-block__cities jsDutiesSelect" multiple="multiple">
                                <option></option>
                                <?php foreach($tags as $tag):?>
                                    <option value="<?=$tag->id?>"
                                            <?php if(is_array($searchModel->tags_id)):?>
                                        <?=in_array($tag->id, $searchModel->tags_id)?'selected':""?>
                                            <?php endif?>
                                    ><?=$tag->name?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="vl-block">
                            <select class="vl-block__cities jsCitiesSelect">
                                <option></option>
                                <?php $city_id = $searchModel->current_city?$searchModel->current_city->id:null; //$city?$city->id:null;?>
                                <?php foreach ($cities as $sel_city): ?>
                                    <option <?= $sel_city->id == $city_id ? 'selected' : '' ?> value="<?=$sel_city->slug?>"><?= $sel_city->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="vl-block">
                            <div class="vl-block__head jsOpenCheck">
                                <p>Требуемый опыт
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">

                                <?php foreach (Resume::$experiences as $key => $experience):?>
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
                                <p>Категория
                                </p><span class="jsBtnPlus btn-active">+</span><span class="jsBtnMinus">-</span>
                            </div>
                            <div class="vl-block__check jsCheckBlock">
                                <?php foreach ($categories as $category): ?>
                                    <label class="checkbox">
                                        <input type="checkbox"
                                            <?php if (isset($searchModel->category_ids) && $searchModel->category_ids !== []): ?>
                                                <?= in_array($category->id, $searchModel->category_ids) ? 'checked' : '' ?>
                                            <?php endif ?>
                                               name="category" data-slug="<?=$category->slug?>" data-id="<?= $category->id ?>"/>
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
                                            <?php if (isset($searchModel->employment_type_ids) && $searchModel->employment_type_ids !== []): ?>
                                                <?= in_array($employment_type->id, $searchModel->employment_type_ids) ? 'checked' : '' ?>
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
                                       value="<?= isset($searchModel->min_salary) ? $searchModel->min_salary : '' ?>"/>
                                <input type="text" name="max_salary"
                                       value="<?= isset($searchModel->max_salary) ? $searchModel->max_salary : '' ?>"/>
                            </div>
                        </div>
                        <button class="vl-btn btn-card btn-red jsAccept jsAcceptScroll">Применить
                        </button>
                    </div>
                </div>
                <div class="v-content-bottom__center scroll">
                    <?php /** @var Resume $resume */
                    if ($dataProvider->models):
                        foreach ($dataProvider->models as $resume):?>
                            <div class="single-card-resume">
                                <div class="single-card-resume__top">
                                    <img class="single-card-resume__left-img"
                                         src="<?=$resume->image_url?$resume->image_url:'/images/empty_user.jpg'?>" alt="<?=$resume->image_url?('Фото '.$resume->employer->second_name.' '.$resume->employer->first_name):'Пустое фото резюме'?>"
                                         role="presentation"
                                    />
                                    <div class="single-card-resume__top-left">
                                        <div class="single-card-resume__head">
                                            <h3>
                                                <?php if($searchModel->category_ids && count($searchModel->category_ids) === 1):?>
                                                <a href="<?=Url::toRoute(['/resume/default/view', 'id'=>$resume->id, 'referer_category'=>$searchModel->category_ids[0]])?>">
                                                    <?= StringHelper::mb_ucfirst(mb_strtolower ( $resume->title)) ?>
                                                </a>
                                                <?php else: ?>
                                                <a href="<?=Url::toRoute(['/resume/default/view', 'id'=>$resume->id])?>">
                                                    <?= StringHelper::mb_ucfirst(mb_strtolower ( $resume->title)) ?>
                                                </a>
                                                <?php endif ?>
                                            </h3>
                                        </div>
                                        <span class="single-card-resume__price">
                                            <?php if($resume->min_salary>0 && $resume->max_salary>0):?>
                                            <?= MoneyFormat::getFormattedAmount($resume->min_salary) ?> - <?= MoneyFormat::getFormattedAmount($resume->max_salary) ?> ₽
                                            <?php elseif($resume->max_salary>0):?>
                                            До <?= MoneyFormat::getFormattedAmount($resume->max_salary) ?> ₽
                                            <?php elseif($resume->min_salary>0):?>
                                            От <?= MoneyFormat::getFormattedAmount($resume->min_salary) ?> ₽
                                            <?php else:?>
                                            По договоренности
                                            <?php endif?>
                                        </span>
                                        <p class="single-card-resume__name">
                                            <?= $resume->employer->second_name ?> <?= $resume->employer->first_name ?>
                                            <?php if($resume->employer->age && $resume->employer->age > 0):?>
                                            · возраст - <?= $resume->employer->age ?>
                                            <?php endif ?>
                                            <?php if($resume->city0):?>
                                            · <?= $resume->city0->name ?>
                                            <?php endif ?>
                                        </p>
                                        <?php if($resume->employment_type): ?>
                                        <p class="single-card-resume__employment"><?= $resume->employment_type->name ?>
                                        </p>
                                        <?php endif ?>
                                        <?php if($resume->lastExperience):?>
                                        <p class="single-card-resume__last-work">Последнее место работы
                                        </p>
                                        <p class="single-card-resume__name-work"><?= $resume->lastExperience->post ?>
                                            , <?= $resume->lastExperience->name ?>
                                        </p>
                                        <p class="single-card-resume__date-work">
                                            <?php if($resume->lastExperience->month_from && $resume->lastExperience->year_from):?>
                                            <?= Experience::$months[$resume->lastExperience->month_from] ?> <?= $resume->lastExperience->year_from ?>
                                            <?php endif ?>
                                            <?php if($resume->lastExperience->month_to && $resume->lastExperience->year_to):?>
                                            — <?= Experience::$months[$resume->lastExperience->month_to] ?> <?= $resume->lastExperience->year_to ?>
                                            <?php endif?>
                                        </p>
                                        <?php endif ?>
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
                                                    <a class="vk-bg" rel="nofollow" target="_blank" href="https://vk.com/<?= $resume->vk ?>">
                                                        <img src="/images/vk.svg" alt="Иконка vk" role="presentation"/></a>
                                                <?php endif ?>
                                                <?php if ($resume->facebook): ?>
                                                    <a class="fb-bg" rel="nofollow" target="_blank" href="https://facebook.com/<?= $resume->facebook ?>">
                                                        <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/></a>
                                                <?php endif ?>
                                                <?php if ($resume->instagram): ?>
                                                    <a class="inst-bg" rel="nofollow" target="_blank" href="https://instagram.com/<?= $resume->instagram ?>">
                                                        <img src="/images/instagram.svg" alt="Иконка instagram" role="presentation"/></a>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif;
                                    if(!Yii::$app->user->isGuest):?>
                                    <a class="btn-card btn-red jsSendMessage" data-id="<?=$resume->id?>">Откликнуться</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
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