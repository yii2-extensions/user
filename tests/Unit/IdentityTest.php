<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Test\Unit;
use yii\base\NotSupportedException;
use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Identity;

final class IdentityTest extends Unit
{
    public function testGetAccount(): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $account = new Account();
        $account->link('identity', $identity);

        $this->assertSame(1, $identity->account->id);
    }

    public function testGetAuthKey(): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $this->assertNotEmpty($identity->getAuthKey());
    }

    public function testFindIdentity(): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $this->assertSame(1, Identity::findIdentity(1)->id);
    }

    public function testFindIdentityByAccessToken(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->expectExceptionMessage(
            'Method "Yii\User\ActiveRecord\Identity::findIdentityByAccessToken" is not implemented.',
        );

        Identity::findIdentityByAccessToken('token');
    }

    public function testValidateAuthKey(): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $this->assertTrue($identity->validateAuthKey($identity->getAuthKey()));
    }
}
