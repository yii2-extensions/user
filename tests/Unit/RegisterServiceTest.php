<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Stub;
use Codeception\Test\Unit;
use RuntimeException;
use Yii;
use yii\db\ActiveRecordInterface;
use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Identity;
use Yii\User\ActiveRecord\Profile;
use Yii\User\ActiveRecord\SocialAccount;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Framework\Repository\PersistenceRepositoryInterface;
use Yii\User\UseCase\Register\RegisterForm;
use Yii\User\UseCase\Register\RegisterService;
use Yii\User\UserModule;

final class RegisterServiceTest extends Unit
{
    public function testRunWithPersistenceRepositoryInterfaceSaveAccountFalse(): void
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

        $this->assertFalse($registerService->run($registerForm));
    }

    public function testRunWithPersistenceRepositoryInterfaceSaveIdentityFalse(): void
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

        $this->assertFalse($registerService->run($registerForm));
    }

    public function testRunWithThrowsExceptionOnExistingUser(): void
    {
        $identity = new Identity();
        $identity->setOldAttributes(['id' => 1]);

        $registerService = new RegisterService(
            Yii::$container->get(Account::class),
            $identity,
            Yii::$container->get(PersistenceRepository::class),
            Yii::$container->get(Profile::class),
            Yii::$container->get(SocialAccount::class),
            Yii::$container->get(UserModule::class),
        );

        /** @var RegisterForm $registerForm */
        $registerForm = Yii::$container->get(RegisterForm::class);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Calling "' . RegisterService::class . '::run()" on existing user');

        $registerService->run($registerForm);
    }
}
