<?php

declare(strict_types=1);

namespace Yii\User\Model;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

/**
 * Represents the data structure for a token object.
 *
 * @property int $id
 * @property string $provider
 * @property string $client_id
 * @property string $data
 * @property string $code
 * @property int $created_at
 * @property string $email
 * @property string $username
 */
final class SocialAccount extends ActiveRecord
{
    public function getIdentity(): ActiveQueryInterface
    {
        return $this->hasOne(Identity::class, ['id' => 'id']);
    }

    public static function tableName(): string
    {
        return '{{%social_account}}';
    }
}
