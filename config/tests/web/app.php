<?php

declare(strict_types=1);


/**
 * @var array $params
 */
return [
    'aliases' => [
        '@app' => dirname(__DIR__, 3),
        '@bower' => '@app/node_modules',
        '@npm' => '@app/node_modules',
        '@resource' => '@vendor/yii2-extensions/app-basic/src/Framework/resource',
        '@runtime' => '@app/tests/public/runtime',
        '@web' => '@app/tests/public',
        '@webroot/assets' => '@web/assets',
        '@yii-user/mailer' => '@app/src/Framework/resource/mailer',
        '@yii-user/migration' => '@app/src/Framework/Migration',
    ],
    'basePath' => dirname(__DIR__, 3),
    'bootstrap' => ['log'],
    'controllerMap' => $params['web.controllerMap'],
    'id' => 'app-tests',
    'language' => 'en-US',
    'name' => 'Web application basic',
    'on beforeAction' => static function (): void {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    },
    'params' => $params['web.params'] ?? [],
    'runtimePath' => dirname(__DIR__, 3) . '/tests/public/runtime',
];
