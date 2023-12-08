<?php

declare(strict_types=1);

use yii\symfonymailer\Mailer;
use Yii\User\ActiveRecord\Identity;
use yii\web\User;

return [
    'container' => [
        'definitions' => [
            Mailer::class => [
                'useFileTransport' => true,
            ],
            User::class => [
                'identityClass' => Identity::class,
                'loginUrl' => ['/login/index'],
            ],
        ],
    ],
];
