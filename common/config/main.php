<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@common/mail/', // Insert path here, you can use aliases
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.adm.tools',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'noreply@rabota.today',
                'password' => 'LX03yJjMei03',
                'port' => '2525', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
    ],
    'modules' => [
        'User' => [
            'class' => 'dektrium\user\Module'
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
    ],

];
