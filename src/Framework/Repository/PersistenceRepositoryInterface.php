<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use yii\db\ActiveRecordInterface;

interface PersistenceRepositoryInterface
{
    public function deleteAll(ActiveRecordInterface $ar, array $condition): bool;

    public function save(ActiveRecordInterface $ar): bool;
}
