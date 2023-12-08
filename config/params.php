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
    'console.aliases' => [
        '@yii-user' => '@vendor/yii2-extensions/user',
        '@yii-user/migration' => '@yii-user/src/Framework/Migration',
    ],
    'web.controllerMap' => [
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
];
