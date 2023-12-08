<?php

declare(strict_types=1);

namespace Yii\User\Tests\Acceptance;

use Yii;
use Yii\User\Tests\Support\AcceptanceTester;

final class RegisterCest
{
    public function disablePage(AcceptanceTester $I): void
    {
        $I->amGoingTo('disable register page.');
        $I->accountRegister(false);

        $I->amGoingTo('go to the page registration.');
        $I->amOnRoute('register/index');

        $I->expectTo('see message register disabled.');
        $I->see(Yii::t('app.basic', 'Web Application'));

        $I->amGoingTo('enable register page.');
        $I->accountRegister(true);
    }

    public function indexPage(AcceptanceTester $I): void
    {
        $I->amGoingTo('navigate to the register page.');
        $I->amOnRoute('register/index');

        $I->wantTo('ensure that register page works.');
        $I->expectTo('see page index.');
        $I->see(Yii::t('yii.user', 'Sign up'), 'h1');
        $I->see(Yii::t('yii.user', 'Please fill out the following fields to Sign up.'));
    }

    public function success(AcceptanceTester $I): void
    {
        $I->amGoingTo('go to the page registration.');
        $I->amOnRoute('register/index');

        $I->expectTo('see registration form.');
        $I->fillField('#registerform-email', 'admin1@example.com');
        $I->fillField('#registerform-username', 'admin1');
        $I->fillField('#registerform-password', '123456');
        $I->fillField('#registerform-passwordrepeat', '123456');
        $I->checkOption('#registerform-accept_terms');
        $I->click(Yii::t('yii.user', 'Sign up'));

        $I->expectTo('see message create user.');
        $I->see(Yii::t('yii.user', 'Your account has been created.'));
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
        $I->checkOption('#registerform-accept_terms');
        $I->click(Yii::t('yii.user', 'Sign up'));

        $I->expectTo('see message create user with email confirmation.');
        $I->see(
            Yii::t(
                'yii.user',
                'Your account has been created. Please check your email for further instructions.',
            ),
        );

        $I->amGoingTo('set confirmation false.');
        $I->accountConfirmation(false);
    }

    public function successWithGeneratePasswordTrue(AcceptanceTester $I): void
    {
        $I->amGoingTo('set generatePassword true.');
        $I->accountGeneratePassword(true);

        $I->amGoingTo('go to the page registration.');
        $I->amOnRoute('register/index');

        $I->expectTo('see registration form.');
        $I->fillField('#registerform-email', 'admin3@example.com');
        $I->fillField('#registerform-username', 'admin3');
        $I->checkOption('#registerform-accept_terms');
        $I->click(Yii::t('yii.user', 'Sign up'));

        $I->expectTo('see message create user with email confirmation.');
        $I->see(
            Yii::t(
                'yii.user',
                'Your account has been created. Please check your email for further instructions.',
            ),
        );

        $I->amGoingTo('set confirmation false.');
        $I->accountConfirmation(false);
    }
}
