<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use yii\base\NotSupportedException;
use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Identity;
use Yii\User\Tests\Support\UnitTester;

final class IdentityCest
{
    public function findIdentity(UnitTester $I): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $I->assertSame(1, Identity::findIdentity(1)->id);
    }

    public function findIdentityByAccessToken(UnitTester $I): void
    {
        $I->expectThrowable(
            new NotSupportedException(
                'Method "Yii\User\ActiveRecord\Identity::findIdentityByAccessToken" is not implemented.'
            ),
            static fn () => Identity::findIdentityByAccessToken('token'),
        );
    }

    public function getAccount(UnitTester $I): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $account = new Account();
        $account->link('identity', $identity);

        $I->assertSame(1, $identity->account->id);
    }

    public function getAuthKey(UnitTester $I): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $I->assertNotEmpty($identity->getAuthKey());
    }

    public function validateAuthKey(UnitTester $I): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $I->assertTrue($identity->validateAuthKey($identity->getAuthKey()));
    }
}
