<?php

declare(strict_types=1);

$params = require_once dirname(__DIR__) . '/params-web.php';

return [
    'aliases' => [
        '@app' => dirname(__DIR__, 3),
        '@bower' => '@app/node_modules',
        '@npm'   => '@app/node_modules',
        '@resource' => '@app/tests/Support/Data/Framework/resource',
        '@runtime' => '@app/tests/Support/Data/public/runtime',
        '@web' => '@app/tests/Support/Data/public',
        '@webroot/assets' => '@web/assets',
        '@yii-user/mailer' => '@app/src/Framework/resource/mailer',
        '@yii-user/migration' => '@app/src/Framework/Migration',
    ],
    'basePath' => dirname(__DIR__, 3),
    'bootstrap' => [
        \Yii\User\Framework\EventHandler\RegisterEventHandler::class,
        'log'
    ],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'sqlite:' . dirname(__DIR__) . '/yiitest.sq3',
        ],
        'i18n' => [
            'translations' => [
                'app.basic' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                ],
                'yii.user' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                ],
            ],
        ],
        'log' => [
            'traceLevel' => 'YII_DEBUG' ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
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
            'identityClass' => \Yii\User\Repository\IdentityRepository::class,
        ],
    ],
    'container' => [
        'definitions' => [
            \yii\symfonymailer\Mailer::class => [
                'useFileTransport' => true,
            ],
        ],
        'singletons' => [
            \yii\web\Session::class => static function (): \yii\web\Session {
                return new \yii\web\Session();
            },
        ],
    ],
    'controllerMap' => [
        'register' => [
            'class' => \Yii\User\UseCase\Register\RegisterController::class,
        ],
        'site' => [
            'class' => \Yii\User\Tests\Support\Data\UseCase\Site\SiteController::class,
        ],
    ],
    'id' => 'app-tests',
    'language' => 'en-US',
    'modules' => [
        'user' => [
            'class' => \Yii\User\UserModule::class,
        ],
    ],
    'name' => 'Web application basic',
    'on beforeAction' => static function (): void {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    },
    'params' => $params,
    'runtimePath' => dirname(__DIR__, 3) . '/tests/Support/Data/public/runtime',
];
