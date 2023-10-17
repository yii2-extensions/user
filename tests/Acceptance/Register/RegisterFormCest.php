<?php

namespace Yii\User\Tests\Acceptance\Register;

use Yii\User\Tests\Support\AcceptanceTester;

final class RegisterFormCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amGoingTo('go to the page registration.');
        $I->amOnRoute('register/index');

        $I->expectTo('see registration form.');
        $I->fillField('#registerform-email', 'admin1@example.com');
        $I->fillField('#registerform-username', 'admin1');
        $I->fillField('#registerform-password', '123456');
        $I->fillField('#registerform-passwordrepeat', '123456');
        $I->click('Sign up');

        $I->expectTo('see message error validation.');
        $I->see('Your account has been created.');
    }

    public function successWithConfirmTrue(AcceptanceTester $I): void
    {
        $I->amGoingTo('set confirmation true.');
        $I->accountConfirmation(true);

        $I->amGoingTo('go to the page registration.');
        $I->amOnRoute('register/index');

        $I->expectTo('see registration form.');
        $I->fillField('#registerform-email', 'admin2@example.com');
        $I->fillField('#registerform-username', 'admin2');
        $I->fillField('#registerform-password', '123456');
        $I->fillField('#registerform-passwordrepeat', '123456');
        $I->click('Sign up');

        $I->expectTo('see message error validation.');
        $I->see('Your account has been created. Please check your email for further instructions.');

        $I->amGoingTo('set confirmation false.');
        $I->accountConfirmation(false);
    }
}
