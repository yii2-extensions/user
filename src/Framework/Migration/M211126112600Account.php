<?php

declare(strict_types=1);

use Yii\User\ActiveRecord\Account;
use Yii\User\ActiveRecord\Identity;
use Yii\User\Framework\Migration\Migration;

final class M211126112600Account extends Migration
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
            Account::tableName(),
            [
                'id' => $id,
                'username' => $this->string(255)->defaultValue('')->notNull(),
                'email' => $this->string(255)->defaultValue('')->notNull(),
                'password_hash' => $this->string(100)->defaultValue('')->notNull(),
                'accept_terms' => $this->boolean()->defaultValue(false),
                'confirmed_at' => $this->integer()->defaultValue(0),
                'unconfirmed_email' => $this->string(255)->defaultValue(''),
                'blocked_at' => $this->integer()->defaultValue(0),
                'registration_ip' => $this->string(45)->defaultValue(''),
                'created_at' => $this->integer()->defaultValue(0),
                'updated_at' => $this->integer()->defaultValue(0),
                'flags' => $this->integer()->defaultValue(0),
                'ip_last_login' => $this->string(45)->defaultValue(''),
                'last_login_at' => $this->integer()->defaultValue(0),
                'last_logout_at' => $this->integer()->defaultValue(0),
            ],
            $this->tableOptions,
        );

        $this->createIndex('idx_account_email', Account::tableName(), ['email']);
        $this->createIndex('idx_account_username', Account::tableName(), ['username']);

        if ($this->db->driverName !== 'sqlite') {
            $this->addForeignKey(
                'fk_account_identity',
                Account::tableName(),
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
        $this->dropTable(Account::tableName());

        return true;
    }
}
