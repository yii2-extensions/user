<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use yii\db\ActiveRecordInterface;
use Yii\User\Model\Account;

final class FinderAccountRepository
{
    public function __construct(private readonly Account $account, private readonly FinderRepository $finderRepository)
    {
    }

    public function findByEmail(string $email): ActiveRecordInterface|array|null
    {
        return $this->finderRepository->findByOneCondition($this->account, ['email' => $email]);
    }

    public function findByUsername(string $username): ActiveRecordInterface|array|null
    {
        return $this->finderRepository->findByOneCondition($this->account, ['username' => $username]);
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ActiveRecordInterface|array|null {
        return filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)
            ? $this->findByEmail($usernameOrEmail)
            : $this->findByUsername($usernameOrEmail);
    }
}
