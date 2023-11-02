<?php

declare(strict_types=1);

use Yii\User\UseCase\Login\LoginController;
use Yii\User\UseCase\Logout\LogoutController;
use Yii\User\UseCase\Register\RegisterController;

return [
    'app.aliases' => [
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
        'app.menu.isguest' => [
            [
                'label' => 'Register',
                'url' => ['/register/index'],
                'order' => 3,
                'category' =>'yii.user',
            ],
            [
                'label' => 'Login',
                'url' => ['/login/index'],
                'order' => 4,
                'category' =>'yii.user',
            ],
        ],
        'app.menu.islogged' => [
            [
                'label' => 'Logout',
                'url' => ['/logout/index'],
                'order' => 1,
                'category' =>'yii.user',
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
