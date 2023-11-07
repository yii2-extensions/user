<?php

declare(strict_types=1);

namespace Yii\User\Tests\Acceptance;

use Yii;
use Yii\User\ActiveRecord\Account;
use Yii\User\Tests\Support\AcceptanceTester;
use Yii\User\Tests\Support\Data\Fixture\AccountFixture;

final class LoginCest
{
    public function indexPage(AcceptanceTester $I): void
    {
        $I->amGoingTo('navigate to the login page.');
        $I->amOnRoute('login/index');

        $I->wantTo('ensure that login page works.');
        $I->expectTo('see page index.');
        $I->see(Yii::t('yii.user', 'Sign in'), 'h1');
        $I->see(Yii::t('yii.user', 'Please fill out the following fields to Sign in.'));
    }

    public function linkResendConfirmationMessage(AcceptanceTester $I): void
    {
        $I->amGoingTo('set confirmation true.');
        $I->accountConfirmation(true);

        $I->amGoingTo('navigate to the login page.');
        $I->amOnRoute('login/index');

        $I->wantTo('ensure that link resend confirmation message works.');
        $I->expectTo('see link resend confirmation message.');
        $I->seeLink(Yii::t('yii.user', 'Didn\'t receive confirmation message?'));

        $I->amGoingTo('set confirmation false.');
        $I->accountConfirmation(false);
    }

    public function success(AcceptanceTester $I): void
    {
        $I->wantTo('security login username submit form success data.');
        $I->haveFixtures([Account::class => AccountFixture::class]);
        $account = $I->grabFixture(Account::class, 'confirmed');

        $I->amGoingTo('navigate to the login page.');
        $I->amOnRoute('login/index');

        $I->wantTo('ensure that login page works.');
        $I->expectTo('see page index.');
        $I->see(Yii::t('yii.user', 'Sign in'), 'h1');
        $I->see(Yii::t('yii.user', 'Please fill out the following fields to Sign in.'));

        $I->expectTo('fill in the form.');
        $I->fillField('#loginform-login', $account->username);
        $I->fillField('#loginform-password', '123456');
        $I->click(Yii::t('yii.user', 'Sign in'));

        $I->expectTo('see that the user is logged in.');
        $I->seeLink(Yii::t('yii.user', 'Logout'));
    }
}
