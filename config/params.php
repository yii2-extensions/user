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
    'app.events' => [
        __DIR__ . '/events/AccountModel.php',
    ],
    'app.params' => [
        'app.menu.isguest' => [
            [
                'label' => \Yii::t('yii.user', 'Register'),
                'url' => ['/register/index'],
                'order' => 3,
            ],
            [
                'label' => \Yii::t('yii.user', 'Login'),
                'url' => ['/login/index'],
                'order' => 4,
            ],
        ],
        'app.menu.islogged' => [
            [
                'label' => \Yii::t('yii.user', 'Logout'),
                'url' => ['/logout/index'],
                'order' => 1,
                'linkOptions' => [
                    'data-method' => 'post',
                ],
            ],
        ],
    ],
];
