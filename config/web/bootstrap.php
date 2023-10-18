<?php

declare(strict_types=1);

use Yii\User\Framework\EventHandler\RegisterEventHandler;

return [
    'bootstrap' => [
        RegisterEventHandler::class,
    ],
];
