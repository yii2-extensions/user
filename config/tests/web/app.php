<?php

declare(strict_types=1);

use yii\db\Connection;
use yii\i18n\PhpMessageSource;
use yii\log\FileTarget;
use yii\symfonymailer\Mailer;
use Yii\User\Framework\EventHandler\RegisterEventHandler;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Framework\Repository\PersistenceRepositoryInterface;
use Yii\User\Model\Identity;
use Yii\User\Tests\Support\Data\UseCase\Site\SiteController;
use Yii\User\UseCase\Register\RegisterController;
use Yii\User\UserModule;
use yii\web\Session;

$params = require_once dirname(__DIR__) . '/params-web.php';

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
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'sqlite:' . dirname(__DIR__) . '/yiitest.sq3',
        ],
        'i18n' => [
            'translations' => [
                'app.basic' => [
                    'class' => PhpMessageSource::class,
                ],
                'yii.user' => [
                    'class' => PhpMessageSource::class,
                ],
            ],
        ],
        'log' => [
            'traceLevel' => 'YII_DEBUG' ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/app.log',
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'your secret key here',
            'enableCsrfValidation' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'user' => [
            'identityClass' => Identity::class,
        ],
    ],
    'container' => [
        'definitions' => [
            Mailer::class => [
                'useFileTransport' => true,
            ],
            PersistenceRepositoryInterface::class => PersistenceRepository::class,
        ],
        'singletons' => [
            Session::class => static function (): Session {
                return new Session();
            },
        ],
    ],
    'controllerMap' => [
        'register' => [
            'class' => RegisterController::class,
        ],
        'site' => [
            'class' => SiteController::class,
        ],
    ],
    'id' => 'app-tests',
    'language' => 'en-US',
    'modules' => [
        'user' => [
            'class' => UserModule::class,
        ],
    ],
    'name' => 'Web application basic',
    'on beforeAction' => static function (): void {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    },
    'params' => $params,
    'runtimePath' => dirname(__DIR__, 3) . '/tests/Support/Data/public/runtime',
];
