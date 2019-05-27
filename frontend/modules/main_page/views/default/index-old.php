<?php

/* @var $this \yii\web\View */
/* @var $categories \common\models\Category[] */
/* @var $vacancies \common\models\Vacancy[] */


use common\models\KeyValue;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
$this->title=KeyValue::findValueByKey('main_page_title')?:'Работа: главная';
$this->registerMetaTag(['description' => KeyValue::findValueByKey('main_page_description')]);
?>

<section class="home">
    <div class="home__aside">
        <div class="home__aside-header">
            <div class="logo">
                <div class="logo__img"><img class="logo__main" src="images/logo.png" alt=""
                                            role="presentation"/><img class="logo__info" src="images/ico-i.png"
                                                                      alt="" role="presentation"/>
                </div>
                <span class="logo__text">Актуальных вакансий сейчас</span>
            </div>
            <span class="home__aside-header-vacancy">Вакансии дня</span>
        </div>
        <div class="home__slider">
            <?php foreach ($vacancies as $vacancy): ?>
                <div class="single-card">
                    <div class="single-card__tr">
                    </div>
                    <div>
                        <?php foreach ($vacancy->category as $category): ?>
                        <a class="btn-card btn-card-small btn-gray" href="<?=Url::to(['/vacancy/default/search', 'category_ids' => json_encode([$category->id])])?>">
                            <?= $category->name ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <h3 class="single-card__title mt5 mb0"><?= $vacancy->post ?></h3>
                    <div class="single-card__info-second">
                        <span class="mr10">Добавлено: <?= Yii::$app->formatter->asTime($vacancy->created_at, 'dd MM yyyy, hh:mm') ?></span>
                        <div class="single-card__view">
                            <img class="single-card__icon mr5" src="images/icon-eye.png" alt="" role="presentation"/>
                            <span>255</span>
                        </div>
                        <a class="d-flex align-items-center ml-auto mt5 mb5" href="#">
                            <img class="single-card__icon" src="images/arr-place.png" alt="" role="presentation"/>
                            <span class="ml5"><?= $vacancy->city ?></span>
                        </a>
                    </div>
                    <div class="single-card__info">
                        <p><?= nl2br(StringHelper::truncate($vacancy->responsibilities, 300, '...')) ?></p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-end mt-auto">
<!--                        <a class="single-card__like mt5 mb5" href="#">-->
<!--                            <i class="fa fa-heart-o"></i>-->
<!--                            <span>В избранное</span>-->
<!--                        </a>-->
                        <a class="btn-card btn-red mt5 mb5 ml15" href="<?=Url::to(['/vacancy/default/view', 'id'=>$vacancy->id])?>">Посмотреть полностью</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="home__main">
        <div class="white-line">
            <div class="white-line__square">
            </div>
        </div>
        <div class="white-line">
            <div class="white-line__square">
            </div>
            <div class="white-line__square">
            </div>
        </div>
        <div class="white-line">
            <div class="white-line__square">
            </div>
        </div>
        <div class="white-line">
            <div class="white-line__square">
            </div>
        </div>
        <div class="white-line">
            <div class="white-line__square">
            </div>
            <div class="white-line__square">
            </div>
        </div>
        <div class="home__main-top">
            <div class="home__main-header">
							<button class="mobile-nav-btn jsOpenNavMenu"><span></span><span></span><span></span>
							</button>
							<div class="filter-overlay nav-overlay jsNavOverlay">
							</div>
                <nav class="home__nav jsNavMenu"><a class="home__nav-item" href="/">Главная</a><a class="home__nav-item"
                                                                                        href="<?=Url::to('resume/search')?>">Резюме</a>

                        <?php if (Yii::$app->user->isGuest): ?>
													<button class="home__nav-item jsLogin">
                            Вход
										</button>
                        <?php else: ?>
													<div class="dropdown jsMenu">
																<span class="home__nav-item jsOpenMenu">
																	<?= Yii::$app->user->identity->username ?>
																</span>
														<div class="dropdown__menu jsShowMenu">
															<a class="home__nav-item" href="/personal-area">
																Личный кабинект
															</a>
                                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'form-logout']) ?>
                                <?= Html::submitButton(
                                    'Выйти',
                                    ['class' => 'btn-logout']
                                ) ?>
                                <?= Html::endForm() ?>
														</div>
													</div>
                        <?php endif ?>


                </nav>
                <div class="home__main-email d-flex align-items-center"><span class="home__main-ico">@</span><a
                            href="mailto:info@vendoram.ru">info@vendoram.ru</a>
                </div>
                <div class="d-flex align-items-center"><i class="home__main-ico fa fa-phone"></i>
                    <div class="d-flex flex-column"><a href="tel:88003553505">+8 800 355-35-05</a><a
                                class="home__callback" href="#">Заказать обратный звонок</a>
                    </div>
                </div>
            </div>
            <div class="home__main-content">
                <?= Html::beginForm(['/main_page/default/search'], 'post', ['class' => 'home__form']) ?>
                    <input name="search_text" class="home__form-input" placeholder="Я ищу..." type="text"/>
                    <div class="home__form-select">
                        <select name="search_type" class="home__form-select-js">
                            <option value="vacancy">Работу</option>
                            <option value="resume">Сотрудников</option>
                        </select>
                    </div>
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i>',
                    ['class' => 'home__search btn-red']
                ) ?>
                <?= Html::endForm() ?>
                <a class="btn btn-red mr20" href="/personal-area/add-resume">разместить резюме</a><a class="btn btn-red"
                                                                             href="<?=Url::to(['/vacancy/default/search'])?>">Найти
                    вакансии</a>
            </div>
        </div>
        <div class="home__main-bottom">
            <div class="home__main-circle">
            </div>
            <h1 class="home__title">Работа
            </h1>
            <p class="home__desc">Сделайте грамотный выбор! Предлагаем размещение и продвижение на новой и
                перспективной площадке <span class="c-red">РаботаДНР</span>. Станьте первым и получайте максимум
                продаж, опережая конкурентов на несколько шагов. Полностью берем на себя все, что связано с
                размещением на маркетплейсе, эффективно управляем ценами и поставками
            </p><img class="home__main-bottom-img" src="images/img1.png" img="" alt="" role="presentation"/>
        </div>
    </div>
    <div class="home__footer">
        <?php foreach ($categories as $category): ?>
            <a class="home__footer-item" href="<?=Url::to(['/vacancy/default/search', 'category_ids' => json_encode([$category->id])])?>"><?= $category->name ?> <?= $category->vacancy_count ?></a>
        <?php endforeach ?>
    </div>
    <img class="home__dots1" src="images/bg-dots.png" alt="" role="presentation"/><img class="home__dots2"
                                                                                       src="images/bg-dots.png"
                                                                                       alt=""
                                                                                       role="presentation"/><img
            class="home__emblem" src="images/img2.png" alt="" role="presentation"/>
    <div class="home__circle">
    </div>
</section>