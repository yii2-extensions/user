<?php

declare(strict_types=1);

namespace Yii\User\Service;

use RuntimeException;
use Yii\User\Framework\Repository\FinderRepository;
use Yii\User\Framework\Repository\PersistenceRepository;
use Yii\User\Model\Account;
use Yii\User\Model\Token;
use Yii\User\UserModule;
use Yiisoft\Security\Random;

final class TokenToUrl
{
    public function __construct(
        private readonly Account $account,
        private readonly FinderRepository $finderRepository,
        private readonly PersistenceRepository $persistenceRepository,
        private readonly Token $token,
        private readonly UserModule $userModule
    ) {
    }

    public function run(int $id, int $type): string
    {
        $tokenCode = '';

        if ($this->register($id, $type)) {
            /** @var Token|null $token */
            $token = $this->finderRepository->findByOneCondition($this->token, ['id' => $id, 'type' => $type]);

            if ($token !== null) {
                $tokenCode = $token->code;
            }
        }

        return $tokenCode;
    }

    public function isExpired(Token $token): bool
    {
        $expirationTime = match ($token->getType()) {
            UserModule::TYPE_CONFIRMATION,
            UserModule::TYPE_CONFIRM_NEW_EMAIL,
            UserModule::TYPE_CONFIRM_OLD_EMAIL => $this->userModule->tokenConfirmWithin,
            UserModule::TYPE_RECOVERY => $this->userModule->tokenRecoverWithin,
            UserModule::TYPE_CONFIRM_2FA => $this->userModule->token2faWithin,
            default => throw new RuntimeException('Expired not available.'),
        };

        return ($token->getCreateAt() + $expirationTime) < time();
    }

    private function register(int $id, int $type): bool
    {
        $account = $this->finderRepository->findById($this->account, $id);

        if ($account === null || $account === []) {
            throw new RuntimeException('Invalid user identity.');
        }

        $this->persistenceRepository->deleteAll($this->token, ['id' => $id, 'type' => $type]);

        if ($this->token->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->token->setAttribute('id', $id);
        $this->token->setAttribute('type', $type);
        $this->token->setAttribute('created_at', time());
        $this->token->setAttribute('code', Random::string());

        return $this->persistenceRepository->save($this->token);
    }
}
