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
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
