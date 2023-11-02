<?php

declare(strict_types=1);

namespace Yii\User\Service;

use RuntimeException;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;
use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Token;
use Yii\User\UserModule;
use Yiisoft\Security\Random;

final class TokenToUrl
{
    public function __construct(
        private readonly Account $account,
        private readonly FinderRepositoryInterface $finderRepository,
        private readonly PersistenceRepositoryInterface $persistenceRepository,
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
        $expirationTime = match ($token->type) {
            UserModule::TYPE_CONFIRMATION,
            UserModule::TYPE_CONFIRM_NEW_EMAIL,
            UserModule::TYPE_CONFIRM_OLD_EMAIL => $this->userModule->tokenConfirmWithin,
            UserModule::TYPE_RECOVERY => $this->userModule->tokenRecoverWithin,
            UserModule::TYPE_CONFIRM_2FA => $this->userModule->token2FAWithin,
            default => throw new RuntimeException('Expired not available.'),
        };

        return ($token->created_at + $expirationTime) < time();
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
