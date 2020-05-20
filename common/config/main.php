<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@', '?'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '',
                    'basePath' => '@frontend/web',
                    'path' => 'media/upload',
                    'name' => 'Изображения',
                ],
            ],
            'watermark' => [
                'source' => __DIR__ . '/logo.png', // Path to Water mark image
                'marginRight' => 5, // Margin right pixel
                'marginBottom' => 5, // Margin bottom pixel
                'quality' => 95, // JPEG image save quality
                'transparency' => 70, // Water mark image transparency ( other than PNG )
                //'targetType' => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200 // Target image minimum pixel size
            ],
            'connectOptions' => array(
                'bind'   => [
                    'upload.pre mkdir.pre mkfile.pre rename.pre archive.pre ls.pre' => [
                        'Plugin.Normalizer.cmdPreprocess',
                        'Plugin.Sanitizer.cmdPreprocess'
                    ],
                    'ls'                                                            => [
                        'Plugin.Normalizer.cmdPostprocess',
                        'Plugin.Sanitizer.cmdPostprocess'
                    ],
                    'upload.presave'                                                => [
                        'Plugin.AutoResize.onUpLoadPreSave',
                        'Plugin.Normalizer.onUpLoadPreSave',
                        'Plugin.Sanitizer.onUpLoadPreSave'
                    ],

                    ],
                'plugin' => [
                    'Normalizer' => [
                        'enable' => true,
                        'targets'  => ['\\','/',':','*','?','"','<','>','|',' '], // target chars
            'replace'  => '_',    // replace to this
            'convmap' => [
                ',' => '_',
                '^' => '_',
                "а" => "a",
                "б" => "b",
                "в" => "v",
                "г" => "g",
                "д" => "d",
                "е" => "e",
                "ё" => "e",
                "ж" => "zh",
                "з" => "z",
                "и" => "i",
                "й" => "j",
                "к" => "k",
                "л" => "l",
                "м" => "m",
                "н" => "n",
                "о" => "o",
                "п" => "p",
                "р" => "r",
                "с" => "s",
                "т" => "t",
                "у" => "u",
                "ф" => "f",
                "х" => "h",
                "ц" => "ts",
                "ч" => "ch",
                "ш" => "sh",
                "щ" => "shch",
                "ы" => "y",
                "э" => "e",
                "ю" => "yu",
                "я" => "ya",
                "А" => "a",
                "Б" => "b",
                "В" => "v",
                "Г" => "g",
                "Д" => "d",
                "Е" => "e",
                "Ё" => "e",
                "Ж" => "zh",
                "З" => "z",
                "И" => "i",
                "Й" => "j",
                "К" => "k",
                "Л" => "l",
                "М" => "m",
                "Н" => "n",
                "О" => "o",
                "П" => "p",
                "Р" => "r",
                "С" => "s",
                "Т" => "t",
                "У" => "u",
                "Ф" => "f",
                "Х" => "h",
                "Ц" => "ts",
                "Ч" => "ch",
                "Ш" => "sh",
                "Щ" => "shch",
                "Ы" => "y",
                "Э" => "e",
                "Ю" => "yu",
                "Я" => "ya",
                " " => "_"
            ]
        ],
    ],
),
        ]
    ],
    'modules' => [
        'User' => [
            'class' => 'dektrium\user\Module'
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
    ],

];
