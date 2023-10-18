<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use yii\db\ActiveRecordInterface;

final class PersistenceRepository extends AbstractRepository implements PersistenceRepositoryInterface
{
    public function deleteAll(ActiveRecordInterface $ar, array $condition): bool
    {
        return $this->execute($ar->getDb(), static fn (): bool => $ar->deleteAll($condition) > 0);
    }

    public function save(ActiveRecordInterface $ar): bool
    {
        return $this->execute($ar->getDb(), static fn (): bool => $ar->save());
    }
}
