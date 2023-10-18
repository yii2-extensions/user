<?php

declare(strict_types=1);

use Yii\User\UseCase\Register\RegisterController;

return [
    'app.aliases' => [
        '@yii-user' => '@vendor/yii2-extensions/user',
        '@yii-user/mailer' => '@yii-user/src/Framework/resource/mailer',
        '@yii-user/migration' => '@yii-user/src/Framework/Migration',
    ],
    'app.controllerMap' => [
        'register' => [
            'class' => RegisterController::class,
        ],
    ],
    'app.events' => [
        __DIR__ . '/events/AccountModel.php',
    ],
    'app.menu.isguest' => [
        [
            'label' => \Yii::t('app.basic', 'Register'),
            'url' => ['/register/index'],
            'order' => 3,
        ],
    ],
];
