<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use yii\base\NotSupportedException;
use Yii\User\Model\Identity;
use yii\web\IdentityInterface;
use Yiisoft\Security\Random;

/**
 * Represents the repository for Identity model.
 */
final class IdentityRepository extends AbstractRepository implements IdentityInterface
{
    public function __construct(private Identity $identity)
    {
    }

    /**
     * @param int|string $id
     */
    public static function findIdentity($id): IdentityInterface|null
    {
        return Identity::findOne($id);
    }

    public static function findIdentityByAccessToken(mixed $token, mixed $type = null)
    {
        throw new NotSupportedException('Method "' . __CLASS__ . '::' . __METHOD__ . '" is not implemented.');
    }

    public function getAuthKey(): string
    {
        return $this->identity->auth_key;
    }

    public function getId(): int|string
    {
        return $this->identity->id;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->identity->auth_key === $authKey;
    }

    public function save(): bool
    {
        $db = $this->identity->getDb();

        return $this->execute($db, fn (): bool => $this->identity->save());
    }

    public function generateAuthKey(): void
    {
        $this->identity->setAttribute('auth_key', Random::string());
    }
}
