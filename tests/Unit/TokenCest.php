<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Yii\User\ActiveRecord\Identity;
use Yii\User\ActiveRecord\Token;
use Yii\User\Tests\Support\UnitTester;
use Yii\User\UserModule;

final class TokenCest
{
    public function testGetIdentity(UnitTester $I): void
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->generateAuthKey();
        $identity->save();

        $token = new Token();
        $token->id = $identity->getId();
        $token->code = 'test';
        $token->type = UserModule::TYPE_CONFIRMATION;
        $token->created_at = time();
        $token->update();

        $I->assertSame(1, $token->identity->id);
    }
}
