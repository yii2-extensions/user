<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Yii;
use Yii\User\Tests\Support\UnitTester;
use Yii\User\UseCase\Login\LoginForm;
use Yii\User\UseCase\Login\LoginService;

final class LoginServiceCest
{
    public function runWithIdentityIsNull(UnitTester $I): void
    {
        $loginService = Yii::createObject(LoginService::class);
        $loginForm = Yii::createObject(LoginForm::class);

        $I->assertFalse($loginService->run($loginForm));
    }
}
