<?php

declare(strict_types=1);

namespace Yii\User\Model;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

use function array_merge;

/**
 * Represents the data structure for an account object.
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $accept_terms
 * @property int $confirmed_at
 * @property string $unconfirmed_email
 * @property int $blocked_at
 * @property string $registration_ip
 * @property int $created_at
 * @property int $updated_at
 * @property int $flags
 * @property string $ip_last_login
 * @property int $last_login_at
 * @property int $last_logout_at
 *
 * Defined relations:
 * @property Identity|null $identity
 * @property Profile|null $profile
 */
final class Account extends ActiveRecord
{
    public function getIdentity(): ActiveQueryInterface
    {
        return $this->hasOne(Identity::class, ['id' => 'id']);
    }

    public function getProfile(): ActiveQueryInterface
    {
        return $this->hasOne(Profile::class, ['id' => 'id']);
    }

    public function scenarios(): array
    {
        return array_merge(
            parent::scenarios(),
            [
                'register' => ['username', 'email', 'password_hash', 'registration_ip', 'created_at', 'confirmed_at'],
            ],
        );
    }

    public static function tableName(): string
    {
        return '{{%account}}';
    }
}
