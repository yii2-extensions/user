<?php

declare(strict_types=1);

use yii\symfonymailer\Mailer;
use Yii\User\Framework\EventHandler\RegisterEventHandler;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Framework\Repository\PersistenceRepositoryInterface;
use Yii\User\Tests\Support\Data\UseCase\Site\SiteController;
use Yii\User\UseCase\Register\RegisterController;
use Yii\User\UserModule;
use yii\web\Session;

/**
 * @var array $params
 */
return [
    'aliases' => [
        '@app' => dirname(__DIR__, 3),
        '@bower' => '@app/node_modules',
        '@npm' => '@app/node_modules',
        '@resource' => '@app/tests/Support/Data/Framework/resource',
        '@runtime' => '@app/tests/Support/Data/public/runtime',
        '@web' => '@app/tests/Support/Data/public',
        '@webroot/assets' => '@web/assets',
        '@yii-user/mailer' => '@app/src/Framework/resource/mailer',
        '@yii-user/migration' => '@app/src/Framework/Migration',
    ],
    'basePath' => dirname(__DIR__, 3),
    'bootstrap' => [
        RegisterEventHandler::class,
        'log',
    ],
    'container' => [
        'singletons' => [
            Session::class => static function (): Session {
                return new Session();
            },
        ],
    ],
    'controllerMap' => $params['app.controllerMap'],
    'id' => 'app-tests',
    'language' => 'en-US',
    'name' => 'Web application basic',
    'on beforeAction' => static function (): void {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    },
    'params' => $params,
    'runtimePath' => dirname(__DIR__, 3) . '/tests/Support/Data/public/runtime',
];
