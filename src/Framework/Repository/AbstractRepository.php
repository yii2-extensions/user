<?php

declare(strict_types=1);

namespace Yii\User\Framework\Repository;

use Closure;
use Yii;
use yii\db\Connection;
use yii\db\Exception;

/**
 * Represents the abstract repository all operations common to all repositories.
 */
abstract class AbstractRepository
{
    protected function execute(Connection $db, Closure $operation): bool
    {
        $transaction = $db->beginTransaction();

        try {
            /** @var bool $result */
            $result = $operation();
            $transaction->commit();

            return $result;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
        }

        return false;
    }
}
