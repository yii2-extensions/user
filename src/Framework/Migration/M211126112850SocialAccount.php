<?php

declare(strict_types=1);

use Yii\User\Framework\Migration\BaseMigration;

class M211126112850SocialAccount extends BaseMigration
{
    public function up(): void
    {
        $id = $this->primaryKey();

        if ($this->db->driverName === 'sqlite') {
            $id = $this->primaryKey()->notNull()->unsigned()->append(
                'REFERENCES identity(id) ON DELETE CASCADE',
            );
        }

        $this->createTable(
            '{{%social_account}}',
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
            '{{%social_account}}',
            ['provider', 'client_id'],
        );

        $this->createIndex(
            'idx_social_account_code',
            '{{%social_account}}',
            'code',
        );

        if ($this->db->driverName !== 'sqlite') {
            $this->addForeignKey(
                'fk_social_account_identity',
                '{{%social_account}}',
                'id',
                '{{%identity}}',
                'id',
                $this->cascade,
                $this->restrict,
            );
        }
    }

    public function down(): void
    {
        $this->dropTable('{{%social_account}}');
    }
}
