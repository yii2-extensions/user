<?php

declare(strict_types=1);

use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Framework\Repository\PersistenceRepositoryInterface;

return [
    'container' => [
        'definitions' => [
            PersistenceRepositoryInterface::class => PersistenceRepository::class,
        ],
    ],
];
