<?php

declare(strict_types=1);

namespace Yii\User\Model;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

/**
 * Represents the data structure for a token object.
 *
 * @property int $id
 * @property string $code
 * @property int $created_at
 * @property int $type
 */
final class Token extends ActiveRecord
{
    public function getIdentity(): ActiveQueryInterface
    {
        return $this->hasOne(Identity::class, ['id' => 'id']);
    }

    public static function primaryKey(): array
    {
        return ['identity_id', 'code', 'type'];
    }

    public static function tableName(): string
    {
        return '{{%token}}';
    }
}
