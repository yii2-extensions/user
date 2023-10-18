<?php

declare(strict_types=1);

namespace Yii\User\Model;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

/**
 * Represents the data structure for a profile object.
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $public_email
 * @property string $location
 * @property string $bio
 * @property string $timezone
 *
 * Defined relations:
 * @property Account|null $account
 * @property Identity|null $identity
 */
final class Profile extends ActiveRecord
{
    public function getAccount(): ActiveQueryInterface
    {
        return $this->hasOne(Account::class, ['id' => 'id']);
    }

    public function getIdentity(): ActiveQueryInterface
    {
        return $this->hasOne(Identity::class, ['id' => 'id']);
    }

    public static function tableName(): string
    {
        return '{{%profile}}';
    }
}
