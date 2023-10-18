<?php

declare(strict_types=1);

use Yii\User\Framework\Migration\BaseMigration;

class M211126112534Identity extends BaseMigration
{
    public function up(): bool
    {
        $this->createTable(
            '{{%identity}}',
            [
                'id' => $this->primaryKey()->notNull()->unsigned(),
                'auth_key' => $this->string(32)->defaultValue(''),
            ],
            $this->tableOptions,
        );

        return true;
    }

    public function down(): bool
    {
        $this->dropTable('{{%identity}}');

        return true;
    }
}
