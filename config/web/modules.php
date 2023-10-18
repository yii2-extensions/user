<?php

declare(strict_types=1);

use Yii\User\UserModule;

return [
    'modules' => [
        'user' => [
            'class' => UserModule::class,
        ],
    ],
];
