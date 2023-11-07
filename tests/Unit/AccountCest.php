<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Profile;
use Yii\User\Tests\Support\UnitTester;

final class AccountCest
{
    public function getProfile(UnitTester $I): void
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

        $I->assertSame('John', $account->profile->first_name);
    }
}
