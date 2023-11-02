<?php

declare(strict_types=1);

/**
 * @var array $params
 */
return [
    'aliases' => [
        '@yii-user' => dirname(__DIR__, 3),
        '@yii-user/migration' => '@yii-user/src/Framework/Migration',
    ],
    'basePath' => dirname(__DIR__, 3),
    'bootstrap' => ['log'],
    'id' => 'app-tests',
    'language' => 'en-US',
    'name' => 'Web application basic',
    'params' => $params,
    'runtimePath' => dirname(__DIR__, 3) . '/tests/Support/Data/public/runtime',
];
