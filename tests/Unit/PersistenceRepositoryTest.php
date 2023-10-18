<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Test\Unit;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Model\Account;

final class PersistenceRepositoryTest extends Unit
{
    public function testSaveTransaction(): void
    {
        $account = new Account();
        $account->username = 'test';
        $account->email = 'test@example.com';
        $account->password_hash = 'testme';

        $persistenceRepository = new PersistenceRepository();

        $this->assertTrue($persistenceRepository->save($account));
        $this->assertSame(1, $account->id);
    }

    public function testSaveTransactionRollback(): void
    {
        $account = new Account();
        $account->username = null;

        $persistenceRepository = new PersistenceRepository();

        $this->assertFalse($persistenceRepository->save($account));
        $this->assertNull($account->id);
    }
}
