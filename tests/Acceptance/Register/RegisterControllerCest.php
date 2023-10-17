<?php

namespace Yii\User\Tests\Acceptance\Register;

use Yii\User\Tests\Support\AcceptanceTester;

final class RegisterControllerCest
{
    public function indexPage(AcceptanceTester $I): void
    {
        $I->amGoingTo('navigate to the Register page.');
        $I->amOnRoute('register/index');

        $I->wantTo('ensure that About page works.');
        $I->expectTo('see page index.');
        $I->see('Sign up', 'h1');
        $I->see('Please fill out the following fields to Sign up.');
    }
}
