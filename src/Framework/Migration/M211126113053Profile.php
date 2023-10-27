<?php

declare(strict_types=1);

use Yii\User\Framework\Migration\BaseMigration;

final class M211126113053Profile extends BaseMigration
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
            '{{%profile}}',
            [
                'id' => $id,
                'first_name' => $this->string(255)->defaultValue(''),
                'last_name' => $this->string(255)->defaultValue(''),
                'public_email' => $this->string(255)->defaultValue(''),
                'location' => $this->string(255)->defaultValue(''),
                'bio' => $this->text()->defaultValue(''),
                'timezone' => $this->string(40)->defaultValue(''),
            ],
            $this->tableOptions,
        );

        if ($this->db->driverName !== 'sqlite') {
            $this->addPrimaryKey(
                '{{%profile_pk}}',
                '{{%profile}}',
                'id',
            );
            $this->addForeignKey(
                'fk_profile_identity',
                '{{%profile}}',
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
        $this->dropTable('{{%profile}}');

        return true;
    }
}
