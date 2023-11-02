<?php

declare(strict_types=1);

use yii\web\Session;

return [
    'container' => [
        'singletons' => [
            Session::class => static function (): Session {
                return new Session();
            },
        ],
    ],
];
