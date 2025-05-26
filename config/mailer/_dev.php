<?php

declare(strict_types=1);

return [
    'class' => \yii\symfonymailer\Mailer::class,
    // 'transport' => [
    //     'dsn' => 'sendmail://default',
    // ],
    // 'transport' => [
    //     // 'scheme' => 'smtps',
    //     'host' => 'smtp.mailsnag.com',
    //     'username' => 'AAeQEkIOUdUP',
    //     'password' => 'lXiiGpyd86RU',
    //     'port' => 2525,
    //     'dsn' => 'native://default',
    // ],
    // 'transport' => [
    // 'dsn' => 'smtp://user:pass@smtp.example.com:25',
    // 'dsn' => 'smtp://AAeQEkIOUdUP:lXiiGpyd86RU@smtp.mailsnag.com:2525',
    // 'dsn' => 'native://default',
    // ],
    'viewPath' => '@app/custom/templates/mail',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure transport
    // for the mailer to send real emails.
    'useFileTransport' => false,
];

// return [
//     'class' => 'yii\swiftmailer\Mailer',
//     'viewPath' => '@app/mail',
//     'useFileTransport' => false,
//     'transport' => [
//         'class' => 'Swift_SmtpTransport',
//         'host' => 'smtp.mailsnag.com',
//         'username' => 'AAeQEkIOUdUP',
//         'password' => 'lXiiGpyd86RU',
//         'port' => '2525',
//         'encryption' => 'STARTTLS',
//     ],
// ];
