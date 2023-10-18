<?php

declare(strict_types=1);

namespace Yii\User\Framework\Migration;

use RuntimeException;
use yii\db\Migration;

class BaseMigration extends Migration
{
    protected string $tableOptions = '';
    protected string $restrict = 'RESTRICT';
    protected string $cascade = 'CASCADE';

    public function init(): void
    {
        match ($this->db->driverName) {
            'mysql' => $this->tableOptions = 'CHARACTER SET utf8mb4 ENGINE=InnoDB',
            'pgsql', 'sqlite' => $this->tableOptions = '',
            'dblib', 'mssql', 'sqlsrv' => $this->restrict = 'NO ACTION',
            default => throw new RuntimeException('Your database is not supported!'),
        };
    }
}
