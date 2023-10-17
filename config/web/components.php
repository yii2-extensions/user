<?php

declare(strict_types=1);

/**
 * @var array $params
 */
return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'sqlite:yiitest.sq3',
        ],
        'i18n' => [
            'translations' => [
                'yii.user' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                ],
            ],
        ],
        'user' => [
            'identityClass' => \Yii\User\Repository\IdentityRepository::class,
        ],
    ],
];
