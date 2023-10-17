<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use PHPForge\Helpers\Password;
use RuntimeException;
use yii\base\Component;
use Yii\User\Framework\Repository\IdentityRepository;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Model\Account;
use Yii\User\Model\Identity;
use Yii\User\Model\Profile;
use Yii\User\Model\SocialAccount;
use Yii\User\UserModule;
use Yiisoft\Security\PasswordHasher;

final class RegisterService extends Component
{
    public function __construct(
        private readonly Account $account,
        private readonly Identity $identity,
        private readonly PersistenceRepository $persistenceRepository,
        private readonly Profile $profile,
        private readonly SocialAccount $socialAccount,
        private readonly UserModule $userModule,
    ) {
    }

    public function run(RegisterForm $registerForm): bool
    {
        $registerEvent = new RegisterEvent($this->userModule->confirmation);

        $this->trigger(RegisterEvent::BEFORE, $registerEvent);

        $identityRepository = new IdentityRepository($this->identity);

        if ($this->identity->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        if ($identityRepository->save() === false) {
            return false;
        }

        $this->account->link('identity', $this->identity);
        $this->account->setScenario('register');
        $this->account->setAttributes($registerForm->getAttributes());

        if ($this->userModule->generatePassword === true) {
            $password = Password::generate(8);
            $this->account->setAttribute('password', $password);
        } else {
            $this->account->setAttribute(
                'password_hash',
                (new PasswordHasher(PASSWORD_ARGON2I))->hash($registerForm->password),
            );
        }

        if ($this->persistenceRepository->save($this->account) === false) {
            return false;
        }

        $this->profile->link('identity', $this->identity);
        $this->socialAccount->link('identity', $this->identity);
        $registerForm->id = $this->identity->id;

        $this->trigger(RegisterEvent::AFTER, $registerEvent);

        return true;
    }
}
