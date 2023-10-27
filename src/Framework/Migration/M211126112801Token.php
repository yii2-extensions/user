<?php

declare(strict_types=1);

use Yii\User\Framework\Migration\BaseMigration;

final class M211126112801Token extends BaseMigration
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
            '{{%token}}',
            [
                'id' => $id,
                'code' => $this->string(32)->notNull(),
                'type' => $this->smallInteger()->notNull(),
                'created_at' => $this->integer()->notNull(),
            ],
            $this->tableOptions,
        );

        $this->createIndex('token_unique', '{{%token}}', ['id', 'code', 'type'], true);

        if ($this->db->driverName !== 'sqlite') {
            $this->addForeignKey(
                'fk_token_identity',
                '{{%token}}',
                'id',
                '{{%identity}}',
                'id',
                $this->cascade,
                $this->restrict,
            );
        }

        return true;
    }

    public function down(): bool
    {
        $this->dropTable('{{%token}}');

        return true;
    }
}
