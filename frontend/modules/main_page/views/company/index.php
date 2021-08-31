<?php

use common\models\KeyValue;
use common\models\Logo;

$this->title = KeyValue::findValueByKey('employer_page_title') ?: 'Работодателям - Поиск сотрудников на сайте rabota.today';
$description = KeyValue::findValueByKey('employer_page_description') ?: 'Информация для работодателей, сайт поиска работы №1. Размещение вакансии, наши партнеры!';

$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name' => 'og:image', 'content' => '/images/og_image.jpg']);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);
/* @var $logos Logo[] */
?>
<main>
		<div class="background">
			<div class="background_top">
				<img src="/images/background_points.png" alt="Точки">
			</div>
			<div class="background_bottom">
				<img src="/images/background_points.png" alt="Точки">
			</div>
		</div>
		<div class="employer">
			<div class="employer_statisticks">

				<div class="employer_statisticks_block">
					<div class="employer_statisticks_block_img laptop">
						<div class="employer_statisticks_block_img_circle">
						</div>
						<img src="/images/laptop.png" alt="Ноутбук">
						<p>1000+</p>
					</div>
					<div class="employer_statisticks_block_text">
						<p>посетителей ежедневно</p>
					</div>
				</div>

				<div class="employer_statisticks_block">
					<div class="employer_statisticks_block_img shout">
						<div class="employer_statisticks_block_img_circle">
						</div>
						<img src="/images/shout.png" alt="Рупор">
						<p>300+</p>
					</div>
					<div class="employer_statisticks_block_text">
						<p>просмотров вакансии за 24 часа</p>
					</div>
				</div>

				<div class="employer_statisticks_block">
					<div class="employer_statisticks_block_img glasses">
						<div class="employer_statisticks_block_img_circle">
						</div>
						<img src="/images/glasses.png" alt="Очки">
						<p>500+</p>
					</div>
					<div class="employer_statisticks_block_text">
						<p>работодателей уже с нами</p>
					</div>
				</div>

			</div>

			<div class="employer_info info-bold">
				<p>Размещая вакансию на сайте Вы получаете гарантированный поток соискателей <span>уже в первые 24 часа</span> после размещения.</p>
			</div>

			<div class="employer_info info-regular">
				<p>Размещая вакансии Вы получаете личную страницу с перечнем вакансий, которую удобно размещать в соц.сетях и получать отклики. Так же ежедневно Вы будете получать резюме от соискателей и собирать их в резерв!</p>
			</div>

			<div class="employer_partners">
				<header>
					<p>С нами уже:</p>
				</header>
				<div class="employer_partners_logo">

                    <?php
                    foreach ($logos as $logo):
                    ?>
                        <div class="employer_partners_logo_item">
                            <?= $logo->company? '<a href="/company/view/' . $logo->company->id . '">' : '' ?><img src="<?= $logo->image ?>" alt="<?= $logo->company->name ?>"><?= $logo->company? '</a>' : ''?>
                        </div>
                    <?php endforeach;?>
<!--					<div class="employer_partners_logo_item">-->
<!--                        <img src="/images/partners/Donbass_post.png" alt="Почта Донбасса">-->
<!--					</div>-->
<!---->
<!--					<div class="employer_partners_logo_item">-->
<!--						<img src="/images/partners/matrix.png" alt="Matrix">-->
<!--					</div>-->
<!---->
<!--					<div class="employer_partners_logo_item">-->
<!--						<img src="/images/partners/a.png" alt="SMM Academy">-->
<!--					</div>-->
<!---->
<!--					<div class="employer_partners_logo_item">-->
<!--						<img src="/images/partners/crb-dnr.png" alt="Центральный Республиканский Банк">-->
<!--					</div>-->
<!---->
<!--					<div class="employer_partners_logo_item">-->
<!--						<img src="/images/partners/moloko.png" alt="Геркулес">-->
<!--					</div>-->
<!---->
<!--					<div class="employer_partners_logo_item">-->
<!--						<img src="/images/partners/galaxy.png" alt="Галактика">-->
<!--					</div>-->
<!---->
<!--					<div class="employer_partners_logo_item">-->
<!--						<img src="/images/partners/family_quarter.png" alt="Семейный квартал">-->
<!--					</div>-->
				</div>
			</div>

			<div class="employer_info info-bold_shadow">
				<p>
					Только у нас Вы можете дать доступ к компании сразу нескольким HR специалистам.<br>
					Все вакансии будут в одном месте!
				</p>
			</div>

			<div class="employer_info info-bold">
				<p>
					Не теряйте время на поиск сотрудников, разместите вакансии<br>
					<span>на rabota today и закройте вакансию за 24 часа!</span>
				</p>
			</div>

			<div class="employer_button">
				<a href="/personal-area/add-vacancy" <?=Yii::$app->user->isGuest?'class="jsLogin"':''?>>
					Разместить вакансию
				</a>
			</div>

			<div class="employer_question">
				<p>Есть вопросы? Напиши нам в соц.сетях</p>
				<div class="employer_question_links">
					<div class="employer_question_links_block">
						<a href="https://vk.com/rabotad0netsk">
							<img src="/images/links/vk.png" alt="Иконка VK">
						</a>
					</div>
				</div>
			</div>
		</div>
	</main>