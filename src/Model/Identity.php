<?php

declare(strict_types=1);

namespace Yii\User\Model;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

/**
 * Represents the data structure for an identity object.
 *
 * @property int $id
 * @property string $auth_key
 *
 * Defined relations:
 * @property Account|null $account
 */
final class Identity extends ActiveRecord
{
    public function getAccount(): ActiveQueryInterface
    {
        return $this->hasOne(Account::class, ['id' => 'id']);
    }

    public static function tableName(): string
    {
        return '{{%identity}}';
    }
}
