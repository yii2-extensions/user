<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use Yii\User\ActiveRecord\Account;

final class FinderAccountRepository
{
    public function __construct(
        private readonly Account $account,
        private readonly FinderRepositoryInterface $finderRepository
    ) {
    }

    public function findByEmail(string $email): Account|null
    {
        $account = $this->finderRepository->findByOneCondition($this->account, ['email' => $email]);

        return $account instanceof Account ? $account : null;
    }

    public function findByUsername(string $username): Account|null
    {
        $account = $this->finderRepository->findByOneCondition($this->account, ['username' => $username]);

        return $account instanceof Account ? $account : null;
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): Account|null
    {
        return filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)
            ? $this->findByEmail($usernameOrEmail)
            : $this->findByUsername($usernameOrEmail);
    }
}
