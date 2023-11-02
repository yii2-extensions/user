<?php

declare(strict_types=1);

use Yii\User\ActiveRecord\Identity;
use Yii\User\Framework\Migration\Migration;

final class M211126112534Identity extends Migration
{
    public function up(): bool
    {
        $this->createTable(
            Identity::tableName(),
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
        $this->dropTable(Identity::tableName());

        return true;
    }
}
