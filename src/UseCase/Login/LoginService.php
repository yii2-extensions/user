<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Login;

use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;
use Yii\User\ActiveRecord\Account;
use yii\web\User;

final class LoginService
{
    public function __construct(
        private readonly PersistenceRepositoryInterface $persistenceRepository,
        private readonly User $user
    ) {
    }

    public function run(Account $account, int $autoLogin = 0): bool
    {
        if ($this->user->login($account->identity, $autoLogin)) {
            $result = $this->persistenceRepository->updateAtttributes($account, ['last_login_at' => time()]);
        }

        return $result ?? false;
    }
}
