<?php

declare(strict_types=1);

use App\UseCase\Site\SiteController;

return [
    'web.controllerMap' => [
        'site' => [
            'class' => SiteController::class,
        ],
    ],
    'web.params' => [
        'app.menu.isguest' => [
            [
                'label' => 'Register',
                'url' => ['/register/index'],
                'order' => 3,
                'category' => 'yii.user',
            ],
            [
                'label' => 'Login',
                'url' => ['/login/index'],
                'order' => 4,
                'category' => 'yii.user',
            ],
        ],
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
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
