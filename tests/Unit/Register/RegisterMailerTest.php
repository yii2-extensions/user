<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit\Register;

use Yii;
use yii\mail\MessageInterface;
use Yii\User\UseCase\Register\RegisterMailer;

use function verify;

final class RegisterMailerTest extends \Codeception\Test\Unit
{
    public mixed $tester;

    public function testRegister(): void
    {
        $registerMailer = Yii::createObject(RegisterMailer::class);

        // using Yii2 module actions to check email was not sent
        $result = $registerMailer->send(Yii::$app->mailer, 'tester@example.com', 'tester', '123456');

        verify($result)->true();

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('yiiuser@example.com');
        verify($emailMessage->getSubject())->equals('Welcome to Web application basic');
        verify($emailMessage->toString())->stringContainsString('Your account on Web application basic has been created.');
    }

    public function testRegisterWithConfirmationTrue(): void
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
        $result = $registerMailer->send(Yii::$app->mailer, 'tester@example.com', 'tester', '123456', $url);

        verify($result)->true();

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('yiiuser@example.com');
        verify($emailMessage->getSubject())->equals('Welcome to Web application basic');
        verify($emailMessage->toString())->stringContainsString('Your account on Web application basic has been created.');
        verify(
            $emailMessage->toString()
        )->stringContainsString('In order to complete your registration, please click the link below.');
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

    public function testRegisterWithShowPasswordTrue(): void
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
        $result = $registerMailer->send(Yii::$app->mailer, 'tester@example.com', 'tester', '123456');

        verify($result)->true();

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();

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
