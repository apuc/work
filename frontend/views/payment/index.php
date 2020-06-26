<?php
$merchant_id = '7012';
$secret_word = 'm648uqdn';
$secret_word2 = 'dz5h59co';
$order_id = '154';
$order_amount = '100.11';
$sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);

?>
<a href="//showstreams.tv/"><img src="//www.free-kassa.ru/img/fk_btn/23.png" title="Бесплатный видеохостинг"></a>
<form method='get' action='https://www.free-kassa.ru/merchant/cash.php'>
    <input type='hidden' name='m' value='<?=$merchant_id?>'>
    <input type='hidden' name='oa' value='<?=$order_amount?>'>
    <input type='hidden' name='o' value='<?=$order_id?>'>
    <input type='hidden' name='s' value='<?=$sign?>'>
    <input type='hidden' name='i' value='1'>
    <input type='hidden' name='lang' value='ru'>
    <input type='hidden' name='us_login' value='crazykoha@gmail.com'>
    <input type='submit' name='pay' value='Оплатить'>
</form>
