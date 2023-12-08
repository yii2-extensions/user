<?php

declare(strict_types=1);

namespace Yii\User\Tests\Acceptance;

use Yii;
use Yii\User\ActiveRecord\Account;
use Yii\User\Tests\Support\AcceptanceTester;
use Yii\User\Tests\Support\Data\AccountFixture;

final class LoginCest
{
    public function allowLogin(AcceptanceTester $I): void
    {
        $I->amGoingTo('disable login page.');
        $I->allowLogin(false);

        $I->amGoingTo('go to the page login.');
        $I->amOnRoute('login/index');

        $I->expectTo('see message home page.');
        $I->see(Yii::t('app.basic', 'Web Application'));

        $I->amGoingTo('enable login page.');
        $I->allowLogin(true);
    }

    public function allowLoginByIps(AcceptanceTester $I): void
    {
        $I->amGoingTo('allow login by ips.');
        $I->allowLoginByIPs(false, ['127.0.0.1', '127.0.0.2', '127.0.0.3']);

        $I->amGoingTo('go to the page login.');
        $I->amOnRoute('login/index');

        $I->expectTo('see message login page.');
        $I->see(Yii::t('yii.user', 'Sign in'), 'h1');
        $I->see(Yii::t('yii.user', 'Please fill out the following fields to Sign in.'));

        $I->amGoingTo('disable login by ips.');
        $I->allowLogin(true, []);
    }

    public function allowLoginByIpsFailed(AcceptanceTester $I): void
    {
        $I->amGoingTo('allow login by ips.');
        $I->allowLoginByIPs(false, ['172.0.0.1']);

        $I->amGoingTo('go to the page login.');
        $I->amOnRoute('login/index');

        $I->expectTo('see message home page.');
        $I->see(Yii::t('app.basic', 'Web Application'));

        $I->amGoingTo('disable login by ips.');
        $I->allowLogin(true, []);
    }

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

    public function successWithEmail(AcceptanceTester $I): void
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
        $I->fillField('#loginform-login', $account->email);
        $I->fillField('#loginform-password', '123456');
        $I->click(Yii::t('yii.user', 'Sign in'));

        $I->expectTo('see that the user is logged in.');
        $I->seeLink(Yii::t('yii.user', 'Logout'));
    }

    public function successWithUsername(AcceptanceTester $I): void
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
