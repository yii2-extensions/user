<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecordInterface;

final class FinderRepository
{
    public function findById(
        ActiveRecordInterface $model,
        int $id,
        string $key = 'id',
    ): ActiveRecordInterface|array|null {
        return $id !== '' ? $this->findByOneCondition($model, [$key => $id]) : null;
    }

    public function findByOneCondition(ActiveRecordInterface $model, array $condition): ActiveRecordInterface|array|null
    {
        return $model::findOne($condition);
    }

    public function findByWhereCondition(ActiveRecordInterface $model, array $condition): ActiveQueryInterface
    {
        return $model::find()->where($condition);
    }
}
