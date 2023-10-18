<?php

declare(strict_types=1);

namespace Yii\User\Framework\EventHandler;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use Yii\User\UseCase\Register\RegisterEvent;
use Yii\User\UseCase\Register\RegisterService;

final class RegisterEventHandler implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app): void
    {
        Event::on(
            RegisterService::class,
            RegisterEvent::AFTER,
            static function (Event $event): void {
                match ($event->userModule->confirmation || $event->userModule->generatePassword) {
                    true => Yii::$app->session->setFlash(
                        'info',
                        Yii::t(
                            'yii.user',
                            'Your account has been created. Please check your email for further instructions.',
                        ),
                    ),
                    false => Yii::$app->session->setFlash(
                        'success',
                        Yii::t(
                            'yii.user',
                            'Your account has been created.',
                        ),
                    ),
                };
            },
        );
    }
}
