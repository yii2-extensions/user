<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Lib\Connector\Yii2\TestMailer;
use Codeception\Module\Yii2;
use PHPForge\Support\Assert;
use Yii;
use yii\mail\MessageInterface;
use Yii\User\Tests\Support\UnitTester;
use Yii\User\UseCase\Register\RegisterMailer;

use function verify;

final class RegisterMailerCest
{
    private TestMailer|null $mailer = null;

    public function _before(UnitTester $I, Yii2 $module): void
    {
        $configMailer = Assert::invokeMethod(
            $module->client,
            'mockMailer',
            [
                [
                    'components' => [
                        'mailer' => [
                            'class' => TestMailer::class,
                        ],
                    ],
                ],
            ],
        );

        $this->mailer = Yii::createObject($configMailer['components']['mailer']);
    }

    public function register(UnitTester $I): void
    {
        $registerMailer = Yii::createObject(RegisterMailer::class);

        // using Yii2 module actions to check email was not sent
        $result = $registerMailer->send($this->mailer, 'tester@example.com', 'tester', '123456');

        verify($result)->true();

        // using Yii2 module actions to check email was sent
        $I->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $I->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('yiiuser@example.com');
        verify($emailMessage->getSubject())->equals('Welcome to Web application basic');
        verify($emailMessage->toString())->stringContainsString('Your account on Web application basic has been created.');
    }

    public function registerWithConfirmationTrue(UnitTester $I): void
    {
        // set confirmation `true`
        Yii::$container->set(
            \Yii\User\UserModule::class,
            [
                '__construct()' => [
                    'confirmation' => true,
                ],
            ],
        );

        $registerMailer = Yii::createObject(RegisterMailer::class);
        $url = 'http://localhost/user/confirm?id=1&code=rjGxEaMozOL1PP_HJeRuUC7Qac7gowQ5';

        // using Yii2 module actions to check email was not sent
        $result = $registerMailer->send($this->mailer, 'tester@example.com', 'tester', '123456', $url);

        verify($result)->true();

        // using Yii2 module actions to check email was sent
        $I->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $I->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('yiiuser@example.com');
        verify($emailMessage->getSubject())->equals('Welcome to Web application basic');
        verify($emailMessage->toString())->stringContainsString('Your account on Web application basic has been created.');
        verify(
            $emailMessage->toString()
        )->stringContainsString('order to complete your registration, please click the link below.');
        verify(
            $emailMessage->toString()
        )->stringContainsString('http://localhost/user/confirm?id=');
        verify(
            $emailMessage->toString()
        )->stringContainsString('If you cannot click the link,');


        // set confirmation `false`
        Yii::$container->set(
            \Yii\User\UserModule::class,
            [
                '__construct()' => [
                    'confirmation' => true,
                ],
            ],
        );
    }

    public function registerWithShowPasswordTrue(UnitTester $I): void
    {
        // set showPassword `true`
        Yii::$container->set(
            \Yii\User\UserModule::class,
            [
                '__construct()' => [
                    'showPassword' => true,
                ],
            ],
        );

        $registerMailer = Yii::createObject(RegisterMailer::class);

        // using Yii2 module actions to check email was not sent
        $result = $registerMailer->send($this->mailer, 'tester@example.com', 'tester', '123456');

        verify($result)->true();

        // using Yii2 module actions to check email was sent
        $I->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $I->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('yiiuser@example.com');
        verify($emailMessage->getSubject())->equals('Welcome to Web application basic');
        verify($emailMessage->toString())->stringContainsString('Your account on Web application basic has been created.');
        verify(
            $emailMessage->toString()
        )->stringContainsString('123456');

        // set showPassword `false`
        Yii::$container->set(
            \Yii\User\UserModule::class,
            [
                '__construct()' => [
                    'showPassword' => false,
                ],
            ],
        );
    }
}
