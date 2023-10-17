<?php

declare(strict_types=1);

namespace Yii\User;

use Yii;
use yii\base\Module;

final class UserModule extends Module
{
    /**
     * Flag for email change.
     */
    public const FLAG_EMAIL_CHANGE = 1;
    /**
     * Flag for email change confirmed.
     */
    public const FLAG_EMAIL_CHANGE_CONFIRMED = 2;
    /**
     * Email is changed right after user enters a new email address.
     */
    public const STRATEGY_INSECURE = 0;
    /**
     * Email is changed after a user clicks a confirmation link sent to their new email address.
     */
    public const STRATEGY_STANDARD = 1;
    /**
     * Email is changed after a user clicks both confirmation links sent to his old and new email addresses.
     */
    public const STRATEGY_SECURE = 2;
    /**
     * Token type for confirmation (for example, account activation).
     */
    public const TYPE_CONFIRMATION = 0;
    /**
     * Token type for recovery (for example, password recovery).
     */
    public const TYPE_RECOVERY = 1;
    /**
     * Token type for new email confirmation.
     */
    public const TYPE_CONFIRM_NEW_EMAIL = 2;
    /**
     * Token type for old email confirmation.
     */
    public const TYPE_CONFIRM_OLD_EMAIL = 3;
    /**
     * Token type for 2fa confirmation.
     */
    public const TYPE_CONFIRM_2FA = 4;
    public const VERSION = '1.0.0';

    public readonly bool $accountGeneratingPassword;
    public readonly bool $confirmation;
    public readonly bool $floatLabels;
    public readonly bool $generatePassword;
    public readonly string $mailerFrom;
    public readonly string $mailerFromName;
    public readonly string $mailerSignatureImage;
    public readonly string $mailerSignatureText;
    public readonly array $mailerWelcomeLayout;
    public readonly string $mailerWelcomeSubject;
    public readonly bool $showPassword;
    public readonly int $token2FAWithin;
    public readonly int $tokenConfirmWithin;
    public readonly int $tokenRecoverWithin;
    public readonly string $urlConfirmation;
    public readonly string $usernameRegex;

    public function __construct($id, Module $module, bool $confirmation = false, array $config = [])
    {
        $this->accountGeneratingPassword = false;
        $this->confirmation = $confirmation;
        $this->floatLabels = true;
        $this->generatePassword = false;
        $this->mailerFrom = 'yiiuser@example.com';
        $this->mailerFromName = 'Yii User Module';
        $this->mailerSignatureImage = Yii::getAlias('@yii-user/mailer/signature/yii-logo.png');
        $this->mailerSignatureText = Yii::t(
            'yii.user',
             '&copy; ' . date('Y') . ' <strong>' . Yii::$app->name . '</strong>',
        );
        $this->mailerWelcomeLayout = ['html' => 'welcome', 'text' => 'text/welcome'];
        $this->mailerWelcomeSubject = Yii::t('yii.user', 'Welcome to {0}', [Yii::$app->name]);
        $this->showPassword = false;
        $this->token2FAWithin = 3600;
        $this->tokenConfirmWithin = 86400;
        $this->tokenRecoverWithin = 3600;
        $this->usernameRegex = '/^[-a-zA-Z0-9_\.@]+$/';
        $this->urlConfirmation = '/user/confirm';

        parent::__construct($id, $module, $config);
    }
}
