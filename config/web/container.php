<?php

declare(strict_types=1);

use yii\symfonymailer\Mailer;
use Yii\User\ActiveRecord\Identity;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Framework\Repository\PersistenceRepositoryInterface;
use yii\web\User;

return [
    'container' => [
        'definitions' => [
            Mailer::class => [
                'useFileTransport' => true,
            ],
            PersistenceRepositoryInterface::class => PersistenceRepository::class,
            User::class => [
                'identityClass' => Identity::class,
                'loginUrl' => ['/login/index'],
            ],
        ],
    ],
];
