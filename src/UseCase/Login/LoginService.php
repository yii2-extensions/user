<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Login;

use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Model\Account;
use yii\web\User;

final class LoginService
{
    public function __construct(
        private readonly PersistenceRepository $persistenceRepository,
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
