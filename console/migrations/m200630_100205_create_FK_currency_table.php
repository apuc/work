<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%FK_currency}}`.
 */
class m200630_100205_create_FK_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%FK_currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
        $this->batchInsert('FK_currency', ['id', 'name'],[
            [186,	'VISA/MASTERCARD KZT'],
            [133,	'FK WALLET RUB'],
            [80,	'Сбербанк RUR'],
            [179,	'MASTERCARD/VISA RUB'],
            [155,	'QIWI WALLET'],
            [63,	'QIWI кошелек'],
            [161,	'QIWI EURO'],
            [123,	'QIWI USD'],
            [45,	'Яндекс.Деньги'],
            [175,	'Яндекс-Деньги'],
            [162,	'QIWI KZT'],
            [153,	'VISA/MASTERCARD+ RUB'],
            [159,	'CARD P2P'],
            [94,	'VISA/MASTERCARD RUB'],
            [100,	'VISA/MASTERCARD USD'],
            [124,	'VISA/MASTERCARD EUR'],
            [160,	'VISA/MASTERCARD'],
            [181,	'Tether USDT'],
            [67,	'VISA/MASTERCARD UAH'],
            [188,	'Google Pay'],
            [187,	'Apple Pay'],
            [184,	'ADVCASH KZT'],
            [136,	'ADVCASH USD'],
            [150,	'ADVCASH RUB'],
            [183,	'ADVCASH EUR'],
            [180,	'Exmo RUB'],
            [174,	'Exmo USD'],
            [147,	'Litecoin'],
            [166,	'BitcoinCash ABC'],
            [172,	'Monero'],
            [173,	'Ripple'],
            [163,	'Ethereum'],
            [167,	'Blackcoin BLK'],
            [168,	'Dogecoin DOGE'],
            [169,	'Emercoin EMC'],
            [170,	'Primecoin XMP'],
            [171,	'Reddcoin RDD'],
            [165,	'ZCASH'],
            [164,	'DASH'],
            [116,	'Bitcoin'],
            [154,	'Skin pay'],
            [131,	'WMZ-bill'],
            [2,	    'WebMoney WMZ'],
            [3,	    'WebMoney WME'],
            [114,	'PAYEER RUB'],
            [115,	'PAYEER USD'],
            [64,	'Perfect Money USD'],
            [69,	'Perfect Money EUR'],
            [79,	'Альфа-банк RUR'],
            [110,	'Промсвязьбанк'],
            [113,	'Русский стандарт'],
            [82,	'Мобильный Платеж Мегафон'],
            [84,	'Мобильный Платеж МТС'],
            [132,	'Мобильный Платеж Tele2'],
            [83,	'Мобильный Платеж Билайн'],
            [99,	'Терминалы России'],
            [158,	'VISA/MC INT'],
            [157,	'VISA UAH CASHOUT'],
            [118,	'Салоны связи'],
            [117,	'Денежные переводы'],
            [70,	'PayPal'],
            [137,	'Мобильный Платеж МегаФон Северо-Западный филиал'],
            [138,	'Мобильный Платеж МегаФон Сибирский филиал'],
            [139,	'Мобильный Платеж МегаФон Кавказский филиал'],
            [140,	'Мобильный Платеж МегаФон Поволжский филиал'],
            [141,	'Мобильный Платеж МегаФон Уральский филиал'],
            [142,	'Мобильный Платеж МегаФон Дальневосточный филиал'],
            [143,	'Мобильный Платеж МегаФон Центральный филиал']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%FK_currency}}');
    }
}
