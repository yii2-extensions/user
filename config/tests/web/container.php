<?php

declare(strict_types=1);

use yii\web\Application;
use yii\web\Session;
use Yiisoft\Config\Config;

/**
 * @var Config $config
 */
return [
    'container' => [
        'singletons' => [
            Application::class => static fn() => new Application($config->get('web')),
            Session::class => static function (): Session {
                return new Session();
            },
        ],
    ],
];
