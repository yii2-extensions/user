<?php

declare(strict_types=1);

use yii\i18n\PhpMessageSource;

return [
    'components' => [
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
