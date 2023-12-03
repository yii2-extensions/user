<?php

declare(strict_types=1);

use App\UseCase\Site\SiteController;

return [
    'app.controllerMap' => [
        'site' => [
            'class' => SiteController::class,
        ],
    ],
    'app.params' => [
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
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
