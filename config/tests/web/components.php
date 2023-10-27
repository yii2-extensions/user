<?php

declare(strict_types=1);

use yii\db\Connection;
use yii\i18n\PhpMessageSource;
use yii\log\FileTarget;

return [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'sqlite:' . dirname(__DIR__) . '/yiitest.sq3',
        ],
        'log' => [
            'traceLevel' => 'YII_DEBUG' ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/app.log',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app.basic' => [
                    'class' => PhpMessageSource::class,
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'TestCodecept',
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
];
