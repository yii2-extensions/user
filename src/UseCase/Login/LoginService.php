<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Login;

use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;
use yii\helpers\IpHelper;
use Yii\User\UserModule;
use yii\web\User;

final class LoginService
{
    public function __construct(
        private readonly PersistenceRepositoryInterface $persistenceRepository,
        private readonly User $user,
        private readonly UserModule $userModule,
    ) {
    }

    public function run(LoginForm $loginForm): bool
    {
        if ($loginForm->account->identity === null) {
            return false;
        }

        $account = $loginForm->account;

        if ($this->user->login($account->identity, $loginForm->autoLogin())) {
            $result = $this->persistenceRepository->updateAtttributes($account, ['last_login_at' => time()]);
        }

        return $result ?? false;
    }

    public function checkAllowedIp(string $userIP): bool
    {
        foreach ($this->userModule->allowLoginByIPs as $allowedIP) {
            if (IpHelper::inRange($userIP, $allowedIP)) {
                return true;
            }
        }

        return false;
    }
}
