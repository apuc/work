<?php
$merchant_id = '214123';
$secret_word = 'm648uqdn';
$secret_word2 = 'dz5h59co';
$order_id = '154';
$order_amount = '100';
$sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);

?>
<a href="//showstreams.tv/"><img src="//www.free-kassa.ru/img/fk_btn/23.png" title="Бесплатный видеохостинг"></a>
<form method='get' action='https://www.free-kassa.ru/merchant/cash.php'>
    <input type='hidden' name='m' value='<?=$merchant_id?>'>
    <input type='hidden' name='oa' value='<?=$order_amount?>'>
    <input type='hidden' name='o' value='<?=$order_id?>'>
    <input type='hidden' name='s' value='<?=$sign?>'>
<!--    <input type='hidden' name='i' value='80'>-->
    <input type='hidden' name='lang' value='ru'>
    <input type='hidden' name='us_login' value='crazykoha@gmail.com'>
    <input type='submit' name='pay' value='Оплатить'>
</form>

<iframe src="http://www.free-kassa.ru/merchant/forms.php?gen_form=1&m=214123&default-sum=100&button-text=Оплатить&encoding=CP1251&type=v3&id=1050766"  width="590" height="320" frameBorder="0" target="_parent" ></iframe>
