<?php
/* @var $employer \common\models\Employer */
use yii\helpers\Html;

?>
<header class="header-wrap jsHeaderIndex">
    <img class="header-wrap__emblem" src="/images/img2.png" alt="" role="presentation"/>
    <div class="container">
        <div class="header">
            <div class="home__main-top">
                <div class="home__main-header">
										<button class="mobile-nav-btn jsOpenNavMenu"><span></span><span></span><span></span>
										</button>
										<div class="filter-overlay nav-overlay jsNavOverlay">
										</div>
                    <nav class="home__nav jsNavMenu">
                        <a class="home__nav-item" href="/">Главная</a>
												<a class="home__nav-item" href="<?=yii\helpers\Url::to('/resume/search')?>">Резюме</a>
                            <?php
                            if (Yii::$app->user->isGuest): ?>
														<button class="home__nav-item jsLogin">
                                Вход
														</button>
                            <?php else: ?>
															<div class="dropdown jsMenu">
																<span class="home__nav-item jsOpenMenu">
																	<?php if(!$employer->first_name && !$employer->second_name):?>
                                                                        <?=explode('@', Yii::$app->user->identity->email)[0]?>
                                                                    <?php else:?>
                                                                        <?= $employer->first_name.' '.$employer->second_name ?>
                                                                    <?php endif?>
																</span>
																<div class="dropdown__menu jsShowMenu">
																	<a class="home__nav-item" href="/personal-area">
																		Личный кабинект
																	</a>
                                    <?= Html::beginForm(['/user/security/logout'], 'post', ['class' => 'form-logout']) ?>
                                    <?= Html::submitButton(
                                        'Выйти',
                                        ['class' => 'home__nav-item btn-logout']
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
                                                                                 href="<?=\yii\helpers\Url::to(['/vacancy/default/search'])?>">Найти
                        вакансии</a>
                </div>
            </div>
        </div>
    </div>
</header>