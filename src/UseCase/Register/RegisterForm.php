<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use Yii;
use yii\base\Model;
use Yii\User\Model\Account;
use Yii\User\UserModule;

final class RegisterForm extends Model
{
    public bool $accept_terms = false;
    public int|null $confirmed_at = null;
    public int|null $created_at = null;
    public string $email = '';
    public int|null $id = null;
    public string $password = '';
    public string $passwordRepeat = '';
    public string $registration_ip = '';
    public string $username = '';

    public function __construct(public readonly UserModule $userModule, array $config = [])
    {
        parent::__construct($config);
    }

    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('yii.user', 'Email'),
            'password' => Yii::t('yii.user', 'Password'),
            'passwordRepeat' => Yii::t('yii.user', 'Password repeat'),
            'username' => Yii::t('yii.user', 'Username'),
        ];
    }

    public function rules(): array
    {
        return [
            // acceptTerms rules
            'acceptTermsRequired' => [
                'accept_terms',
                'compare',
                'compareValue' => true,
                'message' => Yii::t('yii.user', 'You must accept the terms and conditions.'),
            ],
            // create_at only first register
            'createdAtDefault' => ['created_at', 'default', 'value' => time()],
            // confirmed_at only if $this->userModule->confirmation === false
            'confirmedAtDefault' => [
                'confirmed_at',
                'default',
                'value' => $this->userModule->confirmation ? 0 : time(),
            ],
            // username rules
            'usernameTrim'     => ['username', 'trim'],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernamePattern'  => ['username', 'match', 'pattern' => $this->userModule->usernameRegex],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique'   => [
                'username',
                'unique',
                'targetClass' => Account::class,
                'message' => Yii::t('yii.user', 'This username has already been taken.')
            ],
            // email rules
            'emailTrim'     => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern'  => ['email', 'email'],
            'emailUnique'   => [
                'email',
                'unique',
                'targetClass' => Account::class,
                'message' => Yii::t('yii.user', 'This email address has already been taken.')
            ],
            // password rules
            'passwordRequired' => [
                'password',
                'required',
                'skipOnEmpty' => $this->userModule->generatePassword
            ],
            'passwordLength' => ['password', 'string', 'min' => 6, 'max' => 72],
            // password repeat rules
            'passwordRepeatRequired' => [
                'passwordRepeat',
                'required',
                'skipOnEmpty' => $this->userModule->generatePassword
            ],
            'passwordRepeatCompare' => [
                'passwordRepeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('yii.user', 'Passwords do not match'),
            ],
        ];
    }
}
