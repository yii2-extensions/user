<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Test\Unit;
use Yii\User\ActiveRecord\Identity;
use Yii\User\ActiveRecord\Token;
use Yii\User\UserModule;

final class TokenTest extends Unit
{
    public function testGetIdentity(): void
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

        $this->assertSame(1, $token->identity->id);
    }
}
