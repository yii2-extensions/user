<?php

declare(strict_types=1);

namespace Yii\User\Framework\Migration;

final class M211126112534Identity extends Migration
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
