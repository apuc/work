<?php

use yii\helpers\Url;

?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

<table style="
    width: 700px;
		margin-left: auto;
    margin-right: auto;
    ">
	<tr>
		<td>
			<img src="https://rabota.today/media/letters/01.jpg" alt="">
		</td>
	</tr>
	<tr style="
		display: block;
    padding-left: 50px;
    padding-right: 50px;
	">
		<td style="
    margin-right: auto;
    margin-left: auto;
    display: block;">
			<h1 style="
			margin-top: 0;
    	margin-bottom: 0;
			color: #333333;
			font-family: sans-serif;
			font-size: 55px;
			font-weight: 700;
			text-align: center;
			">
				<?= $name ?>
			</h1>
			<h4 style="
			margin-top: 0;
    	margin-bottom: 0;
			padding-left: 90px;
			color: #333333;
			font-family: sans-serif;
			font-size: 26px;
			font-weight: 400;
			">
				мы нашли твое резюме!
			</h4>
			<h4 style="
			margin-top: 0;
    	margin-bottom: 0;
			color: #333333;
			font-family: sans-serif;
			font-size: 26px;
			font-weight: 700;
			text-align: center;
			">
				Тебе нужна еще работа?
			</h4>
		</td>
	</tr>
	<tr style="
		display: block;
    padding-left: 50px;
    padding-right: 50px;
	">
		<td>
			<p style="
			margin-top: 45px;
			margin-bottom: 50px;
			color: #333333;
			font-family: sans-serif;
			font-size: 16px;
			font-weight: 400;
			text-align: justify;
			">
				Не теряй времени даром! <strong>Мы рекомендуем</strong> изучить вакансии на нашей площадке, которая постоянно пополняется новыми
				предложениями. Для этого тебе нужно подтвердить адрес электронной почты перейдя по ссылке ниже.
			</p>
		</td>
	</tr>
	<tr style="
		display: block;
    padding-left: 50px;
    padding-right: 50px;
	">
		<td style="display: block; margin: 0 auto;">
            <?php if(!empty($variable)):?>
			<a href="https://rabota.today/confirm/<?=$id?>/<?=$variable?>" target="_blank" style="
				display: block;
				width: 400px;
				margin: 0 auto;
				padding: 8px 14px;
				font-family: sans-serif;
				font-size: 16px;
				font-weight: 700;
				color: #fbfcfc;
				text-align: center;
				text-decoration: none;
				border: 1px solid rgba(0, 0, 0, .1);
				border-radius: 28px;
			">
				<span style="
				display: block;
				padding: 12px 38px;
				/*background-image: linear-gradient(to left, #dd3d34 0%, #af2a22 99%, #af2a22 100%);*/
				background-color: #dd3d34;
				border-radius: 28px;
				">
					Подтвердить адрес электронной почты
				</span>
			</a>
            <?php endif?>
		</td>
	</tr>
	<tr style="
		display: block;
		margin-top: 70px;
		margin-bottom: 40px;
    padding-left: 50px;
    padding-right: 50px;
	">
		<td style="
    margin-right: auto;
    margin-left: auto;
    display: block;">
			<h1 style="
			margin-top: 0;
    	margin-bottom: 0;
    	margin-left: 63px;
			color: #333333;
			font-family: sans-serif;
			font-size: 30px;
			font-weight: 700;
			text-align: left;
			">
				На всякий случай,
			</h1>
			<h4 style="
			margin-top: 0;
    	margin-bottom: 0;
			margin-left: 135px;
			color: #333333;
			font-family: sans-serif;
			font-size: 21px;
			font-weight: 400;
			text-align: left;
			">
				посмотри еще наши рекомендации!
			</h4>
		</td>
	</tr>
	<tr style="
		display: block;
		margin-bottom: 17px;
    padding-left: 50px;
    padding-right: 50px;
	">
		<td style="
    margin-right: auto;
    margin-left: auto;
    display: block;">
			<p style="
			margin-top: 0;
    	margin-bottom: 0;
			color: #333333;
			font-family: sans-serif;
			font-size: 17px;
			font-weight: 400;
			text-align: center;
			">
				Более 2 354 человек это сделали!
			</p>
		</td>
	</tr>
	<tr style="
		display: block;
		margin-bottom: 75px;
    padding-left: 50px;
    padding-right: 50px;
	">
		<td style="display: block; margin: 0 auto;">
			<a href="https://rabota.today/" style="
				display: block;
				width: 400px;
				margin: 0 auto;
				padding: 15px 38px;
				font-family: sans-serif;
				font-size: 16px;
				font-weight: 700;
				color: #dd3d34;
				text-align: center;
				text-decoration: none;
				border: 1px solid #dd3d34;
				border-radius: 23px;
			">
					Посмотреть и подписаться на рекомендации
			</a>
		</td>
	</tr>
	<tr style="
		display: block;
		padding-bottom: 35px;
    padding-left: 50px;
    padding-right: 50px;
    background: url(https://rabota.today/media/letters/pi.png) no-repeat 50% 100%;
	">
		<td style="
    width: 190px; padding-left: 150px;">
			<p style="
				margin: 0;
				font-family: sans-serif;
				font-size: 21px;
				font-weight: 700;
				color: #0352a1;
			">
				Мы еще ближе:
			</p>
		</td>
		<td style="width: 45px; padding-right: 37px;">
			<a href="https://vk.com/rabotad0netsk">
				<img src="https://rabota.today/media/letters/letter_vk.png" alt="">
			</a>
		</td>
		<td style="width: 45px;">
		</td>
	</tr>
</table>

</body>
</html>