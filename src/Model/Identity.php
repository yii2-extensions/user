<?php

declare(strict_types=1);

namespace Yii\User\Model;

use yii\base\NotSupportedException;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yiisoft\Security\Random;

/**
 * Represents the data structure for an identity object.
 *
 * @property int $id
 * @property string $auth_key
 *
 * Defined relations:
 * @property Account|null $account
 */
final class Identity extends ActiveRecord implements IdentityInterface
{
    public function getAccount(): ActiveQueryInterface
    {
        return $this->hasOne(Account::class, ['id' => 'id']);
    }

    /**
     * @param int|string $id the user ID to be looked for (primary key) in the database.
     */
    public static function findIdentity($id): IdentityInterface|null
    {
        return Identity::findOne($id);
    }

    public static function findIdentityByAccessToken(mixed $token, mixed $type = null)
    {
        throw new NotSupportedException('Method "' . __CLASS__ . '::' . __METHOD__ . '" is not implemented.');
    }

    public function generateAuthKey(): void
    {
        $this->setAttribute('auth_key', Random::string());
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    public static function tableName(): string
    {
        return '{{%identity}}';
    }
}
