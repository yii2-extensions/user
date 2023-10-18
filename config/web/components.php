<?php

declare(strict_types=1);

use yii\i18n\PhpMessageSource;
use Yii\User\Model\Identity;

return [
    'components' => [
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
