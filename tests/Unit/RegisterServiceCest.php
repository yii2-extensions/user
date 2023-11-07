<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Stub;
use RuntimeException;
use Yii;
use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;
use yii\db\ActiveRecordInterface;
use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Identity;
use Yii\User\ActiveRecord\Profile;
use Yii\User\ActiveRecord\SocialAccount;
use Yii\User\Tests\Support\UnitTester;
use Yii\User\UseCase\Register\RegisterForm;
use Yii\User\UseCase\Register\RegisterService;
use Yii\User\UserModule;

final class RegisterServiceCest
{
    public function runWithPersistenceRepositoryInterfaceSaveAccountFalse(UnitTester $I): void
    {
        $account = new Account();
        $identity = new Identity();
        $identity->id = 1;

        /** @var PersistenceRepositoryInterface $persistenceRepository */
        $persistenceRepository = Stub::makeEmpty(
            PersistenceRepositoryInterface::class,
            [
                'save' => function (ActiveRecordInterface $record) use ($identity): bool {
                    return match ($record instanceof Account) {
                        true => false,
                        default => $identity->save() === true,
                    };
                },
            ],
        );

        $registerService = new RegisterService(
            $account,
            $identity,
            $persistenceRepository,
            Yii::$container->get(Profile::class),
            Yii::$container->get(SocialAccount::class),
            Yii::$container->get(UserModule::class),
        );

        /** @var RegisterForm $registerForm */
        $registerForm = Yii::$container->get(RegisterForm::class);

        $I->assertFalse($registerService->run($registerForm));
    }

    public function runWithPersistenceRepositoryInterfaceSaveIdentityFalse(UnitTester $I): void
    {
        /** @var PersistenceRepositoryInterface $persistenceRepository */
        $persistenceRepository = Stub::makeEmpty(PersistenceRepositoryInterface::class, ['save' => false]);
        $identity = new Identity();

        $registerService = new RegisterService(
            Yii::$container->get(Account::class),
            $identity,
            $persistenceRepository,
            Yii::$container->get(Profile::class),
            Yii::$container->get(SocialAccount::class),
            Yii::$container->get(UserModule::class),
        );

        /** @var RegisterForm $registerForm */
        $registerForm = Yii::$container->get(RegisterForm::class);

        $I->assertFalse($registerService->run($registerForm));
    }

    public function runWithThrowsExceptionOnExistingUser(UnitTester $I): void
    {
        $identity = new Identity();
        $identity->setOldAttributes(['id' => 1]);

        $registerService = new RegisterService(
            Yii::$container->get(Account::class),
            $identity,
            Yii::$container->get(PersistenceRepositoryInterface::class),
            Yii::$container->get(Profile::class),
            Yii::$container->get(SocialAccount::class),
            Yii::$container->get(UserModule::class),
        );

        /** @var RegisterForm $registerForm */
        $registerForm = Yii::$container->get(RegisterForm::class);

        $I->expectThrowable(
            new RuntimeException('Calling "' . RegisterService::class . '::run()" on existing user'),
            static fn () => $registerService->run($registerForm),
        );
    }
}
