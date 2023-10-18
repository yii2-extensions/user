<?php

declare(strict_types=1);

use yii\db\Connection;
use yii\i18n\PhpMessageSource;
use Yii\User\Model\Identity;

return [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'sqlite:yiitest.sq3',
        ],
        'i18n' => [
            'translations' => [
                'yii.user' => [
                    'class' => PhpMessageSource::class,
                ],
            ],
        ],
        'user' => [
            'identityClass' => Identity::class,
        ],
    ],
];
