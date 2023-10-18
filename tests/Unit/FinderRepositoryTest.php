<?php

declare(strict_types=1);

namespace Yii\User\Tests\Unit;

use Codeception\Test\Unit;
use yii\db\ActiveRecordInterface;
use Yii\User\Framework\Repository\FinderRepository;
use Yii\User\Model\Identity;

final class FinderRepositoryTest extends Unit
{
    public function testFindById(): void
    {
        $activeRecordInterface = $this->generateRecord();

        $this->assertTrue($activeRecordInterface->save());

        $finderRepository = new FinderRepository();

        /** @var Identity $result */
        $result = $finderRepository->findById($activeRecordInterface, 1);

        $this->assertInstanceOf(ActiveRecordInterface::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testFindByIdWithEmptyId(): void
    {
        $activeRecordInterface = $this->generateRecord();

        $this->assertTrue($activeRecordInterface->save());

        $finderRepository = new FinderRepository();

        $result = $finderRepository->findById($activeRecordInterface, 0);

        $this->assertNull($result);
    }

    public function testFindByOneCondition(): void
    {
        $activeRecordInterface = $this->generateRecord();

        $this->assertTrue($activeRecordInterface->save());

        $finderRepository = new FinderRepository();

        /** @var Identity $result */
        $result = $finderRepository->findByOneCondition($activeRecordInterface, ['id' => 1]);

        $this->assertInstanceOf(ActiveRecordInterface::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testFindByWhereCondition(): void
    {
        $activeRecordInterface = $this->generateRecord();

        $this->assertTrue($activeRecordInterface->save());

        $finderRepository = new FinderRepository();

        $result = $finderRepository->findByWhereCondition($activeRecordInterface, ['id' => 1])->one();

        $this->assertInstanceOf(ActiveRecordInterface::class, $result);
        $this->assertSame(1, $result->id);
    }

    private function generateRecord(): ActiveRecordInterface
    {
        $identity = new Identity();
        $identity->id = 1;
        $identity->auth_key = "1234567890";

        return $identity;
    }
}
