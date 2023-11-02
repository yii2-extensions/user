<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use Yii;
use yii\base\Model;
use Yii\User\ActiveRecord\Account;
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

    public function __construct(private readonly UserModule $userModule, array $config = [])
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
            [
                'accept_terms',
                'compare',
                'compareValue' => true,
                'message' => Yii::t('yii.user', 'You must accept the terms and conditions.'),
            ],
            // create_at only first register
            ['created_at', 'default', 'value' => time()],
            // confirmed_at only if $this->userModule->confirmation === false
            ['confirmed_at', 'default', 'value' => $this->userModule->confirmation ? 0 : time()],
            // username rules
            ['username', 'trim'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['username', 'match', 'pattern' => $this->userModule->usernameRegex],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => Account::class,
                'message' => Yii::t('yii.user', 'This username has already been taken.'),
            ],
            // email rules
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => Account::class,
                'message' => Yii::t('yii.user', 'This email address has already been taken.'),
            ],
            // password rules
            ['password', 'required', 'skipOnEmpty' => $this->userModule->generatePassword],
            ['password', 'string', 'min' => 6, 'max' => 72],
            // password repeat rules
            ['passwordRepeat', 'required', 'skipOnEmpty' => $this->userModule->generatePassword],
            [
                'passwordRepeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('yii.user', 'Passwords do not match'),
            ],
        ];
    }
}
