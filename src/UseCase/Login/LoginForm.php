<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Login;

use Yii;
use yii\base\Model;
use Yii\User\ActiveRecord\Account;
use Yii\User\UserModule;
use Yiisoft\Security\PasswordHasher;

final class LoginForm extends Model
{
    public string $login = '';
    public string $password = '';
    public int $rememberMe = 0;

    public function __construct(
        private readonly Account|null $account,
        private readonly PasswordHasher $passwordHasher,
        private readonly UserModule $userModule,
        array $config = []
    ) {
        parent::__construct($config);
    }

    public function attributeLabels(): array
    {
        return [
            'login' => Yii::t('yii.user', 'Login'),
            'password' => Yii::t('yii.user', 'Password'),
        ];
    }

    public function rules(): array
    {
        return [
            // login rules
            ['login', 'trim'],
            ['login', 'string', 'min' => 3, 'max' => 255],
            ['login', 'match', 'pattern' => $this->userModule->usernameRegex],
            ['login', 'required'],
            [
                'login',
                function (string $attribute): void {
                    $this->addError($attribute, Yii::t('yii.user', 'Invalid login or password.'));
                },
                'when' => fn (): bool => $this->account === null,
            ],
            // password validate
            ['password', 'trim'],
            ['password', 'string', 'min' => 6, 'max' => 72],
            ['password', 'required'],
            [
                'password',
                function (string $attribute): void {
                    $this->addError($attribute, Yii::t('yii.user', 'Invalid login or password.'));
                },
                'when' => fn (): bool => $this->account === null ||
                    $this->passwordHasher->validate($this->password, $this->account->password_hash) === false,
            ],
        ];
    }

    public function autoLogin(): int
    {
        return $this->rememberMe ?: 0;
    }
}
