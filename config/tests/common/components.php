<?php

declare(strict_types=1);

use yii\caching\FileCache;
use yii\db\Connection;
use yii\log\FileTarget;

return [
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
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
    ],
];
