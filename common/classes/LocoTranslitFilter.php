<?php


namespace common\classes;


use Yii;

class LocoTranslitFilter
{

    /**
     * @var string the name of the attribute to be translit.
     */
    public $translitAttribute;

    /**
     * @var boolean whether to translit value only when the attribute value is null or empty string.
     * Defaults to true. If false, the attribute will always be translit.
     */
    public $setOnEmpty = true;

    /**
     * Max length string
     * @var type int
     */
    public $maxLength = 100;

    /**
     * @var boolean To lowercase after translate.
     */
    public $toLowCase = true;

//    /**
//     * Validates the attribute of the object.
//     * @param CModel $object the object being validated
//     * @param string $attribute the attribute being validated
//     */
//    protected function validateAttribute($object, $attribute)
//    {
//        if ($this->setOnEmpty && !$this->isEmpty($object->$attribute))
//        {
//            return;
//        }
//
//        if (!$object->hasAttribute($this->translitAttribute))
//        {
//            throw new CException(Yii::t('app', 'Active record "{class}" is trying to select an invalid column "{column}". Note, the column must exist in the table or be an expression with alias.', array('{class}' => get_class($object), '{column}' => $this->translitAttribute)));
//        }
//
//        $object->$attribute = self::cyrillicToLatin($object->getAttribute($this->translitAttribute), $this->maxLength, $this->toLowCase);
//    }

    /**
     * Translit text from cyrillic to latin letters.
     *
     * @param string $text the text being translit.
     * @return string
     */
    static public function cyrillicToLatin($text, $maxLength, $toLowCase)
    {
        $dictionary = array(
            'й' => 'i',
            'ц' => 'c',
            'у' => 'u',
            'к' => 'k',
            'е' => 'e',
            'н' => 'n',
            'г' => 'g',
            'ш' => 'sh',
            'щ' => 'shch',
            'з' => 'z',
            'х' => 'h',
            'ъ' => '',
            'ф' => 'f',
            'ы' => 'y',
            'в' => 'v',
            'а' => 'a',
            'п' => 'p',
            'р' => 'r',
            'о' => 'o',
            'л' => 'l',
            'д' => 'd',
            'ж' => 'zh',
            'э' => 'e',
            'ё' => 'e',
            'я' => 'ya',
            'ч' => 'ch',
            'с' => 's',
            'м' => 'm',
            'и' => 'i',
            'т' => 't',
            'ь' => '',
            'б' => 'b',
            'ю' => 'yu',

            'Й' => 'I',
            'Ц' => 'C',
            'У' => 'U',
            'К' => 'K',
            'Е' => 'E',
            'Н' => 'N',
            'Г' => 'G',
            'Ш' => 'SH',
            'Щ' => 'SHCH',
            'З' => 'Z',
            'Х' => 'X',
            'Ъ' => '',
            'Ф' => 'F',
            'Ы' => 'Y',
            'В' => 'V',
            'А' => 'A',
            'П' => 'P',
            'Р' => 'R',
            'О' => 'O',
            'Л' => 'L',
            'Д' => 'D',
            'Ж' => 'ZH',
            'Э' => 'E',
            'Ё' => 'E',
            'Я' => 'YA',
            'Ч' => 'CH',
            'С' => 'S',
            'М' => 'M',
            'И' => 'I',
            'Т' => 'T',
            'Ь' => '',
            'Б' => 'B',
            'Ю' => 'YU',

            '\-' => '-',
            '\s' => '-',

            '[^a-zA-Z0-9\-]' => '',

            '[-]{2,}' => '-',
        );

        foreach ($dictionary as $from => $to)
        {
            $text = mb_ereg_replace($from, $to, $text);
        }

        $text = mb_substr($text, 0, $maxLength, Yii::$app->charset);
        if ($toLowCase)
        {
            $text = mb_strtolower($text, Yii::$app->charset);
        }

        return trim($text, '-');
    }

}