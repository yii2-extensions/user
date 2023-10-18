<?php

declare(strict_types=1);

namespace Yii\User;

use Yii;
use yii\base\Module;
use yii\helpers\Url;

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

    public readonly string $mailerSignatureText;
    public readonly string $mailerWelcomeSubject;
    public readonly string $urlConfirmation;

    public function __construct(
        $id,
        Module $module,
        public readonly bool $confirmation = false,
        public readonly bool $floatLabels = true,
        public readonly bool $generatePassword = false,
        public readonly string $mailerFrom = 'yiiuser@example.com',
        public readonly string $mailerFromName = 'Yii User Module',
        public readonly string $mailerSignatureImage = '@yii-user/mailer/signature/yii.svg',
        string $mailerSignatureText = null,
        public readonly array $mailerWelcomeLayout = ['html' => 'welcome', 'text' => 'text/welcome'],
        string|null $mailerWelcomeSubject = null,
        public readonly bool $showPassword = false,
        public readonly int $token2FAWithin = 3600,
        public readonly int $tokenConfirmWithin = 86400,
        public readonly int $tokenRecoverWithin = 3600,
        string $urlConfirmation = null,
        public readonly string $usernameRegex = '/^[-a-zA-Z0-9_\.@]+$/',
        array $config = [],
    )
    {
        $this->mailerSignatureText = $mailerSignatureText ??
            Yii::t(
                'yii.user',
                '&copy; ' . date('Y') . ' <strong>' . Yii::$app->name . '</strong>',
            );
        $this->mailerWelcomeSubject = $mailerWelcomeSubject ?? Yii::t('yii.user', 'Welcome to {0}', [Yii::$app->name]);
        $this->urlConfirmation = $urlConfirmation ??= Url::to('/user/confirm');

        parent::__construct($id, $module, $config);
    }
}
