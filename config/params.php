<?php

declare(strict_types=1);

use Yii\User\UseCase\Login\LoginController;
use Yii\User\UseCase\Logout\LogoutController;
use Yii\User\UseCase\Register\RegisterController;

return [
    'common.aliases' => [
        '@yii-user' => '@vendor/yii2-extensions/user',
        '@yii-user/mailer' => '@yii-user/src/Framework/resource/mailer',
        '@yii-user/migration' => '@yii-user/src/Framework/Migration',
    ],
    'app.controllerMap' => [
        'login' => [
            'class' => LoginController::class,
        ],
        'logout' => [
            'class' => LogoutController::class,
        ],
        'register' => [
            'class' => RegisterController::class,
        ],
    ],
    'app.params' => [
        'app.menu.islogged' => [
            [
                'label' => 'Logout',
                'url' => ['/logout/index'],
                'order' => 1,
                'category' => 'yii.user',
                'linkOptions' => [
                    'data-method' => 'post',
                ],
            ],
        ],
    ],
    'console.aliases' => [
        '@yii-user' => '@vendor/yii2-extensions/user',
        '@yii-user/migration' => '@yii-user/src/Framework/Migration',
    ],
];
