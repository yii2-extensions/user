<?php

declare(strict_types=1);

use Yii\User\ActiveRecord\Identity;
use Yii\User\ActiveRecord\SocialAccount;
use Yii\User\Framework\Migration\Migration;

final class M211126112850SocialAccount extends Migration
{
    public function up(): bool
    {
        $id = $this->primaryKey();

        if ($this->db->driverName === 'sqlite') {
            $id = $this->primaryKey()->notNull()->unsigned()->append(
                'REFERENCES identity(id) ON DELETE CASCADE',
            );
        }

        $this->createTable(
            SocialAccount::tableName(),
            [
                'id' => $id,
                'provider' => $this->string(255)->defaultValue(''),
                'client_id' => $this->string(255)->defaultValue(''),
                'data' => $this->text()->defaultValue(''),
                'code' => $this->string(32)->defaultValue(''),
                'created_at' => $this->integer()->defaultValue(0),
                'email' => $this->string(255)->defaultValue(''),
                'username' => $this->string(255)->defaultValue(''),
            ],
            $this->tableOptions,
        );

        $this->createIndex(
            'idx_social_account_client_id',
            SocialAccount::tableName(),
            ['provider', 'client_id'],
        );

        $this->createIndex(
            'idx_social_account_code',
            SocialAccount::tableName(),
            'code',
        );

        if ($this->db->driverName !== 'sqlite') {
            $this->addForeignKey(
                'fk_social_account_identity',
                SocialAccount::tableName(),
                'id',
                Identity::tableName(),
                'id',
                $this->cascade,
                $this->restrict,
            );
        }

        return true;
    }

    public function down(): bool
    {
        $this->dropTable(SocialAccount::tableName());

        return true;
    }
}
