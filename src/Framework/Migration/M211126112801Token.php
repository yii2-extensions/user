<?php

declare(strict_types=1);

use Yii\User\ActiveRecord\Identity;
use Yii\User\ActiveRecord\Token;
use Yii\User\Framework\Migration\Migration;

final class M211126112801Token extends Migration
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
            Token::tableName(),
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
                Token::tableName(),
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
        $this->dropTable(Token::tableName());

        return true;
    }
}
