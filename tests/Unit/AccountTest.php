<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Test\Unit;
use Yii\User\Model\Account;
use Yii\User\Model\Profile;

final class AccountTest extends Unit
{
    public function testGetProfile(): void
    {
        $account = new Account();
        $account->username = 'test';
        $account->email = 'test@example.com';
        $account->password_hash = 'testme';
        $account->save();

        $profile = new Profile();
        $profile->link('account', $account);
        $profile->first_name = 'John';
        $profile->last_name = 'Doe';
        $profile->save();

        $this->assertSame('John', $account->profile->first_name);
    }
}
