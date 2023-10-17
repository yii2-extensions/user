<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use Yii;
use yii\mail\MailerInterface;
use yii\symfonymailer\Mailer;
use Yii\User\UserModule;

final class RegisterMailer
{
    public function __construct(private readonly UserModule $userModule)
    {
    }

    public function send(
        MailerInterface $mailer,
        string $email,
        string $username,
        string $password,
        string|null $url = null
    ): bool {
        $showPassword = $this->userModule->showPassword;

        if ($this->userModule->generatePassword) {
            $showPassword = true;
        }

        /** @var Mailer $mailer */
        $mailer->viewPath = '@yii-user/mailer';
        $mailer->view->params = [
            'logo' => Yii::getAlias('@yii-user/mailer/signature/yii.svg'),
            'signatureText' => $this->userModule->mailerSignatureText,
        ];

        return $mailer
            ->compose(
                $this->userModule->mailerWelcomeLayout,
                [
                    'username' => $username,
                    'password' => $password,
                    'url' => $url,
                    'showPassword' => $showPassword,
                    'signatureText' => $this->userModule->mailerSignatureText,
                ],
            )
            ->setFrom([$this->userModule->mailerFrom => $this->userModule->mailerFromName])
            ->setTo([$email => $username])
            ->setSubject($this->userModule->mailerWelcomeSubject)
            ->send();
    }
}
