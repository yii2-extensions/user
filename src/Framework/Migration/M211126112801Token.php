<?php

declare(strict_types=1);

use Yii\User\Framework\Migration\BaseMigration;

class M211126112801Token extends BaseMigration
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
                'fk_token_user',
                '{{%token}}',
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
        $this->dropTable('{{%token}}');
    }
}
